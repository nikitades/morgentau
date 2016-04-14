@extends('app')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/homePage.css') }}">
@stop

@section('content')
    <div id="pageData">
        <div id="slider" class="homePage-slider">
            <div id="credentials">
                <div class="name">{!! $texts['HEADER-NAME'] !!}</div>
                <div class="rank">{!! $texts['HEADER-RANK'] !!}</div>
            </div>
        </div>
        <div id="schedule-news" class="clearfix">
            <div id="schedule">
                <h2 class="title shadowed"><?= $texts['HOMEPAGE-SCHEDULE-TITLE'] ?></h2>
                <div class="content shadowed-light">
                    <?= $texts['HOMEPAGE-SCHEDULE-CONTENT'] ?>
                </div>
            </div>
            <div id="news">
                <h2 class="title"><?= $texts['HOMEPAGE-NEWS-TITLE'] ?></h2>
                <ul class="news-holder">
                    @foreach($news as $newsItem)
                        <li class="news-holder--news-item clearfix">
                            <div class="news-holder--news-item--calendar-icon">
                                <div class="news-holder--news-item--calendar-icon--month-name">
                                <span>
                                    {{ \App\Date::monthsRuShort(date('m', strtotime($newsItem->date))) }}
                                </span>
                                </div>
                                <div class="news-holder--news-item--calendar-icon--date">
                                <span>
                                    {{ intval(date('d', strtotime($newsItem->date))) }}
                                </span>
                                </div>
                            </div>
                            <div class="news-holder--news-item--news-item-content">
                                <a href="{{ $newsItem->url() }}">{{ $newsItem->title }}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @if (sizeof($service_categories))
            <div id="services">
                @foreach ($service_categories as $scat)
                    <div class="services--service">
                        <a href="{{ $scat->url }}">
                            <img class="services--service--gray" src="{{ $scat->images[0]->url() }}" alt="">
                            <img class="services--service--regular" src="{{ $scat->images[1]->url() }}" alt="">
                            <span>{{ $scat->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
        {!! $texts['MAP'] !!}
    </div>
@stop