<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterPicture;
use App\Tweet;
use Illuminate\Support\Facades\Log;


class FagpicController extends Controller
{
    // 今は未使用
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
            ->paginate(12);

        return view('layouts.main2',['tweets' => $tweets]);
    }

    /* 検索 */
    public function search(Request $request)
    {
        $name = $request->input('name');
        Log::debug('[HTTP REQUEST] search input:'.$name);

        /* フォームが空白の場合はトップページにリダイレクト */
        if($name === null)
        {
            return redirect('/');
        }

        $tweets = (new Tweet)
            ->join('twitter_users', 'tweets.user_id','=','twitter_users.id')
            ->where('name', $name)
            ->orderBy('tweets.id', 'desc')
            ->paginate(12);

        return view('layouts.main2', ['tweets' => $tweets]);
    }
}
