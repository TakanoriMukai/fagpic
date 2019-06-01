@extends('layouts.base')
@section('title','Fagpic')

@section('header')
<nav class="navbar">
    <!-- <div  class="navbar-brand"><a href='/'>Fagpic</a></div> -->
    <!-- <div  class="navbar-brand"><img alt="Fagpic" src="{{ asset('/img/fagpic_logo1.png')}}"></div> -->
    <a  class="navbar-brand" href='/'></a>
</nav>
@endsection

@section('content')

<!-- <div class="card-body"> -->
<div class="container">
    <div class="row">
    <form class="form-inline col-12" method="get" action="{{route('search')}}">
        @csrf
        <!-- <div class="form-group"> -->
            <div class="search_container col-4">
                <input type="text" name="keyword" value="{{$keyword}}" placeholder="Enter search keyword" >
                <input type="submit" value="&#xf002">
            </div>
            <div class="btn-group btn-group-toggle col-8" data-toggle="buttons">
                <!-- <div class="input-group"> -->
                @if ($radio_checked === 'username')
                    <label class="btn btn-secondary active btn-sm">
                        <input type="radio" name="radios" value="username" autocomplete="off" checked>
                        User name
                    </label>
                    　<label class="btn btn-secondary btn-sm">
                        <input type="radio" name="radios"value="acountname" autocomplete="off">
                        Account name
                    </label>
                @elseif ($radio_checked === 'acountname')
                    <label class="btn btn-secondary active btn-sm">
                        <input type="radio" name="radios" value="username" autocomplete="off">
                        User name
                    </label>
                    　<label class="btn btn-secondary btn-sm">
                        <input type="radio" name="radios"value="acountname" autocomplete="off" checked>
                        Account name
                    </label>
                @endif

                <!-- </div> -->
            </div>
            <!-- <button class="btn btn-primary btn-sm" type="submit" >Search</button> -->
        <!-- </div> -->
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
</div>

@endsection
