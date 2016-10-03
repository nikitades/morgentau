@extends('pages.regularPage')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/newsList.css') }}">
@stop

@section('after-content')
    <div class="news-list">
        <ul class="news">
            @foreach($news as $newsItem)
                <li>
                    <h3>
                        <a href="{{ $newsItem->url() }}">{{ \App\Date::fullDate($newsItem->date) }}</a>
                    </h3>
                    <p>
                        <a href="{{ $newsItem->url() }}">{{ $newsItem->title }}</a>
                    </p>
                    <p><i><a href="{{ $newsItem->url() }}">Подробнее...</a></i></p>
                </li>
            @endforeach
        </ul>
    </div>
@stop