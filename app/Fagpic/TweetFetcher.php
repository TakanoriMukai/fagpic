<?php

namespace App\Fagpic;

use Abraham\TwitterOAuth\TwitterOAuth;

class TweetFetcher implements Fetcher
{
    protected $tweet_object;
    protected $conn;
    protected $filter;

    public function __construct($consumer_key, $consumer_secret)
    {
        $this->conn = new TwitterOAuth( $consumer_key,$consumer_secret);
    }

    /*  最新のツイートを取得する。 */
    public function fetch()
    {
        try{
            $this->tweet_object = $this->conn->get("search/tweets", ["q" => $this->filter]);
        } catch(\TwitterOAuthException $e) {
            throw $e;
        }
    }

    /* 検索フィルタを設定する。 */
    public function setFilter(string $filter)
    {
        $this->filter = $filter;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function getTweetObject()
    {
        return $this->tweet_object;
    }
}
