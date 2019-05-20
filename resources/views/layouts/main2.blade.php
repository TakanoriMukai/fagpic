@extends('layouts.base')
@section('title','Fagpic')

@section('header')
<nav class="navbar">
    <div  class="navbar-brand"><a href='/'>Fagpic</a></div>
</nav>
@endsection

@section('content')

<div class="row">
    <form method="get" action="{{route('search')}}">
        {{ csrf_field() }}
        <input type="input" name="name">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


{{ $tweets->links() }}

<div class="row">
@foreach($tweets as $tweet)
    <div class="col-lg-4">
        <div class="spinner-grow" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <blockquote class="twitter-tweet" data-lang="ja">
            <p lang="ja" dir="ltr">{{$tweet->text}} 
                <a href="{{$tweet->url}}">{{$tweet->url}}
                </a>
            </p>&mdash; {{$tweet->name}} (@{{$tweet->screen_name}}) 
            <a href="{{$tweet->tweet_url}}.'?ref_src=twsrc%5Etfw'">{{$tweet->posted_at}}
            </a>
        </blockquote> 
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
    </div>
@endforeach
</div>
{{ $tweets->links() }}

@endsection
