<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterPicture;
use App\Tweet;

class FagpicController extends Controller
{
    //
    public function main()
    {
        $pictures = (new TwitterPicture)
            ->join('tweets', 'tweet_id', '=', 'tweets.id')
            ->join('twitter_users', 'tweets.user_id','=','twitter_users.id')
            ->orderBy('tweet_id','desc')
            ->get();    

        return view('layouts.main', ['pictures' => $pictures]);
    }

    public function main2()
    {
        $tweets = (new Tweet)
            ->join('twitter_users', 'tweets.user_id','=','twitter_users.id')
            ->orderBy('tweets.id', 'desc')
            ->get();

        return view('layouts.main2',['tweets' => $tweets]);
    }
}
