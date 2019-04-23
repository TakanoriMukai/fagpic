@extends('layouts.base')
@section('title','Fagpic')

@section('header')
<nav class="navbar">
    <div  class="navbar-brand"><a href='/'>Fagpic</a></div>
</nav>
@endsection

@section('content')

<div class="row">
    @foreach($tweets as $tweet)
        <blockquote class="twitter-tweet" data-lang="ja">
            <p lang="ja" dir="ltr">{{$tweet->text}} 
                <a href="{{$tweet->url}}">{{$tweet->url}}
                </a>
            </p>&mdash; {{$tweet->name}} (@{{$tweet->screen_name}}) 
            <a href="{{$tweet->tweet_url}}.'?ref_src=twsrc%5Etfw'">{{$tweet->posted_at}}
            </a>
        </blockquote> 
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
    @endforeach
</div>
{{ $tweets->links() }}

@endsection
