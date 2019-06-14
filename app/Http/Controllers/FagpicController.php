<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TwitterPicture;
use App\Tweet;
use Illuminate\Support\Facades\Log;


class FagpicController extends Controller
{
    // 今は未使用
    // public function main()
    // {
    //     $pictures = (new TwitterPicture)
    //         ->join('tweets', 'tweet_id', '=', 'tweets.id')
    //         ->join('twitter_users', 'tweets.user_id','=','twitter_users.id')
    //         ->orderBy('tweet_id','desc')
    //         ->get();    

    //     return view('layouts.main', ['pictures' => $pictures]);
    // }

    public function main2()
    {
        $tweets = (new Tweet)
            ->join('twitter_users', 'tweets.user_id','=','twitter_users.id')
            ->orderBy('tweets.id', 'desc')
            ->paginate(12);

        return view('layouts.main2',
            ['tweets' => $tweets, 
             'keyword' => '', 
             'checkedUserName' => 'checked',
             'checkedAccountName' => 'checked']);
    }

    /* 検索 */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $checkedUserName = $request->input('checkedUserName');
        $checkedAccountName = $request->input('checkedAccountName');
        Log::debug('[HTTP REQUEST] search input:'.$keyword.' checkedUserName:'.$checkedUserName.' checkedAccountName:'.$checkedAccountName);

        /* フォームが空白の場合はトップページにリダイレクト */
        if(!$keyword)
        {
            return redirect('/');
        }

        if( $checkedUserName && $checkedAccountName ) {
            $tweets = (new Tweet)
                ->join('twitter_users', 'tweets.user_id','=','twitter_users.id')
                ->orWhere('screen_name', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orderBy('tweets.id', 'desc')
                ->paginate(12);
        }
        else if ( $checkedAccountName ){
            // アカウント名（screen name）検索
            $tweets = (new Tweet)
                ->join('twitter_users', 'tweets.user_id','=','twitter_users.id')
                ->where('screen_name', 'LIKE', "%{$keyword}%")
                ->orderBy('tweets.id', 'desc')
                ->paginate(12);
        } else { 
            // ユーザ名検索
            $tweets = (new Tweet)
                ->join('twitter_users', 'tweets.user_id','=','twitter_users.id')
                ->where('name', 'LIKE', "%{$keyword}%")
                ->orderBy('tweets.id', 'desc')
                ->paginate(12);
        }

        if($checkedUserName==='on'){
            $checkedUserName = 'checked';
        }
        if($checkedAccountName==='on'){
            $checkedAccountName = 'checked';
        }

        return view('layouts.main2', 
        ['tweets' => $tweets,  'keyword' => $keyword, 
         'checkedUserName' => $checkedUserName==='checked' ? 'checked' : '' ,
         'checkedAccountName' => $checkedAccountName==='checked' ? 'checked': '']);
    }
}
