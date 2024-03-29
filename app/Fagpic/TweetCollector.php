<?php

namespace App\Fagpic;

use App\Tweet;
use App\TwitterUser;
use App\TwitterPicture;
use App\TwitterHashtag;
use App\HashtagRelation;
use Illuminate\Support\Facades\Log;

class TweetCollector
{
    public function collect($statuses)
    {
        $new_tweet = count($statuses);
        $url_count = 0;
        $new_tag = 0;

        // Modelに格納する。
        foreach( $statuses as $status )
        {
            // 登録済みのtweetであればスキップ
            if( $this->hasTweet($status['id']) )
            {
                $new_tweet--;
                Log::debug('       -> id: '.$status['id'].'は既に登録済みtweetのためスキップします。');
                continue;
            }

            // tweet_users table
            $this->shouldAddUser($status['user_id'], $status['name'], $status['screen_name']);

            // tweet_users table name,screen_nameが更新されていた場合反映する
            $this->shouldUpdateUser($status['user_id'], $status['name'], $status['screen_name']);

            // tweets table
            $tweet = new Tweet;
            $tweet->id = $status['id'];
            $tweet->user_id = $status['user_id'];
            $tweet->tweet = $status['text'];
            $tweet->posted_at = date('Y-m-d H:i:s', strtotime((string) $status['created_at']));
            $tweet->favorite_count = $status['favorite_count'];
            $tweet->retweet_count = $status['retweet_count'];
            $tweet->tweet_url = 'https://twitter.com/'.$status['screen_name'].'/status/'.$status['id'];
            $tweet->save();

            // picture table
            foreach( $status['urls'] as $url )
            {
                $picture = new TwitterPicture;
                $picture->url = $url;
                $picture->file_path = null; // file_path DL後に格納
                $picture->size = 0;         // size DL後に格納
                $picture->failure_count = 0;
                $picture->tweet_id = $status['id'];
                $picture->save();
                $url_count++;
            }

            // hashtags table
            foreach( $status['hashtags'] as $tag)
            {
                if(!$this->hasHashtag($tag))
                {
                    // 未登録のhashtagであれば追加
                    $hashtag = new TwitterHashtag;
                    $hashtag->tag_name = $tag;
                    $hashtag->save();
                    $new_tag++;
                }
            
                // hashtag_relations table
                $tag_relation = new HashtagRelation;
                $hashtag_id = (new TwitterHashtag)->where('tag_name',$tag )->first()->id;
                $tag_relation->tweet_id = $status['id'];
                $tag_relation->hashtag_id = $hashtag_id;
                $tag_relation->save();
            }
        }

        return (object)array(
            'tweet_num' => count($statuses),
            'new_tweet' => $new_tweet,
            'url_count' => $url_count,
            'new_tag'   => $new_tag);
    }
    // tweetの存在チェック
    private function hasTweet($id)
    {
        return Tweet::where('id', $id)->count() > 0;
    }

    // 指定idのtwitterユーザの存在チェック
    private function hasUser($id)
    {
        return TwitterUser::where('id', $id)->count() > 0;
    }

    // hashtagの存在チェック
    private function hasHashtag($hashtag)
    {
        return TwitterHashtag::where('tag_name', $hashtag)->count() > 0;
    }

    // nameが更新されているかチェック
    private function isSameName($id, $name)
    {
        return (TwitterUser::where('id', $id)->select('name')->first())['name'] === $name;
    }

    // screen_nameが更新されているかチェック
    private function isSameScreenName($id, $screen_name)
    {
        return (TwitterUser::where('id', $id)->select('screen_name')->first())['screen_name'] === $screen_name;
    }

    private function shouldAddUser($id, $name, $screen_name)
    {
        if( !$this->hasUser($id) )
        {
            // 未登録のTwitterユーザであれば追加
            $tweet_user = new TwitterUser;
            $tweet_user->id = $id;
            $tweet_user->name = $name;
            $tweet_user->screen_name = $screen_name;
            $tweet_user->save();
        }
    }

    private function shouldUpdateUser($id, $name, $screen_name)
    {
        if( !$this->isSameName($id, $name) || 
        !$this->isSameScreenName($id, $screen_name) )
        {
            TwitterUser::where('id', $id)
                ->update(['name' => $name, 'screen_name' => $screen_name]);
            Log::debug('       -> id: '.$id.'を更新しました。name:'.$name.' screen_name:'.$screen_name );
        }
    }
}
