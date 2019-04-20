<?php

namespace App\Fagpic;

class TweetParser extends Parser
{
    private $urls = array();

    public function getUrls()
    {
        return $this->urls;
    }

    /* GET search/tweets で取得した結果を渡す */
    public function parse( $object )
    {
        foreach( $object->statuses as $status )
        {
            // tweet階層
            $hashtags = array();
            foreach( $status->entities->hashtags as $hashtag )
            {
                // hashtag階層
                array_push($hashtags, $hashtag->text);
            }

            $urls = array();
            if( array_key_exists( 'media', $status->entities ))
            {
                foreach( $status->entities->media as $media )
                {
                    // 画像url階層
                    array_push( $this->urls, [$status->id => $media->media_url_https] );
                    array_push( $urls, $media->media_url_https);
                }
            }
            
            $this->setData( [ 'id'    => $status->id,
                            'text'  => $status->text,
                            'user_id'   => $status->user->id,
                            'name'  => $status->user->name,
                            'screen_name'   => $status->user->screen_name,
                            'created_at'    => $status->created_at,
                            'favorite_count'=> $status->favorite_count,
                            'retweet_count'   => $status->retweet_count,
                            'hashtags'      => $hashtags,
                            'urls'  => $urls ]);
        }
    }
}
