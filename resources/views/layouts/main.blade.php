@extends('layouts.base')
@section('title','Fagpic')

@section('header')
<nav class="navbar">
    <div  class="navbar-brand"><a href='/'>Fagpic</a></div>
</nav>
@endsection

@section('content')

@foreach($pictures as $picture)
<blockquote class="twitter-tweet" data-lang="ja">
    <p lang="ja" dir="ltr">{{$picture->text}} 
        <a href="{{$picture->url}}">{{$picture->url}}
        </a>
    </p>&mdash; {{$picture->name}} (@{{$picture->screen_name}}) 
    <a href="{{$picture->tweet_url}}.'?ref_src=twsrc%5Etfw'">{{$picture->posted_at}}
    </a>
</blockquote> 
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
@endforeach

@endsection
