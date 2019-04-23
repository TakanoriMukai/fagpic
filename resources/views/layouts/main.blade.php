@extends('layouts.base')
@section('title','Fagpic')

@section('header')
<nav class="navbar">
    <div  class="navbar-brand"><a href='/'>Fagpic</a></div>
</nav>
@endsection

@section('content')

@foreach($pictures as $picture)
<div class="card-body">
    <div class="row">
        <div class="col-lg-4">
            <div class="bs-component">
                <div class="card mb-3">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <a href="{{$picture->url}}">
                            <img class="card-img" src="{{config('gcp.storage_path','').''.$picture->file_path}}">{{$picture->file_path}}</img>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
