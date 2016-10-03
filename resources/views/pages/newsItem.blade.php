@extends('app')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/newsItem.css') }}">
@stop

@section('content')
    <div id="article">
        <div class="holder">
            <h1>{{ \App\Date::fullDate($item->date) }}</h1>
            <div class="body">
                <h2>{{ $item->title }}</h2>
                {!! $item->full !!}
            </div>
            <a href="/news" class="all-news">{{ $texts['ALL-NEWS'] }}</a>
        </div>
    </div>
    <div id="pageData">
        <div id="slider">
            <div id="credentials">
                <div class="name">{!! $texts['HEADER-NAME'] !!}</div>
                <div class="rank">{!! $texts['HEADER-RANK'] !!}</div>
            </div>
        </div>
    </div>
@stop