<?php

namespace App\Fagpic;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterReporter implements Reporter
{
    protected $conn;

    public function __construct($consumer_key, $consumer_secret,$access_token,$access_token_secret)
    {
        $this->conn = new TwitterOAuth( $consumer_key,
                                        $consumer_secret,
                                        $access_token,
                                        $access_token_secret);
    }
    public function report(string $text)
    {
        return $this->conn->post("statuses/update", ["status" => $text]);
    }
}