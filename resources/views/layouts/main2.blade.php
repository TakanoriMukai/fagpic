@extends('layouts.base')
@section('title','Fagpic')

@section('header')
<nav class="navbar">
    <div  class="navbar-brand"><a href='/'>Fagpic</a></div>
</nav>
@endsection

@section('content')

<div class="card-body">
    <form class="form-inline" method="get" action="{{route('search')}}">
        @csrf
        <div class="form-group">
            <input class="form-control" type="input" name="keyword" value={{$keyword}}>
            <div class="radio">
                <div class="input-group">
                @if ($radio_checked === 'username')
                    <label>
                        <input type="radio" name="radios" value="username" checked>
                        ユーザ名
                    </label>
                    　<label>
                        <input type="radio" name="radios"value="acountname">
                        アカウント名
                    </label>
                @elseif ($radio_checked === 'acountname')
                    <label>
                        <input type="radio" name="radios" value="username" >
                        ユーザ名
                    </label>
                    　<label>
                        <input type="radio" name="radios"value="acountname" checked>
                        アカウント名
                    </label>
                @endif

                </div>
            </div>
            <button class="btn btn-primary" type="submit" >Search</button>
        </div>
    </form>
</div>


{{ $tweets->links() }}

<div class="row">
@foreach($tweets as $tweet)
    <div class="col-lg-4 col-md-6">
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
