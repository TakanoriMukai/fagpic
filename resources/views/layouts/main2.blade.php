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
    <form class="form-group" method="get" action="{{route('search')}}">
        @csrf
            <div class="search_container m-2">
                <input type="text" name="keyword" value="{{$keyword}}" placeholder="Enter search keyword" >
                <input type="submit" value="&#xf002">
            </div>
            <div class="form-check mx-3 my-1">
                <input class="form-check-input" type="checkbox" name="checkedUserName" id="check1" {{$checkedUserName}}>
                <label class="form-check-label" for="check1">User name</label>
            </div>
            <div class="form-check mx-3 my-1">
                <input class="form-check-input" type="checkbox" name="checkedAccountName" id="check2" {{$checkedAccountName}}>
                <label class="form-check-label" for="check2">Account name</label>
            </div>

            <!-- <button class="btn btn-primary btn-sm" type="submit" >Search</button> -->
        <!-- </div> -->
    </form>
    </div>
    <div class="row">
        <div class="col-4">
        {{ $tweets->onEachSide(2)->links() }}
        </div>
    </div>
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
{{ $tweets->onEachSide(2)->links() }}
</div>

@endsection
