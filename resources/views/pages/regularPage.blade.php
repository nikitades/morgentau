@extends('app')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/regularPage.css') }}">
@stop

@section('content')
    @yield('before-body')
    <div id="article">
        <div class="holder">
            <h1>{{ $page->header }}</h1>
            <div class="body">
                {!! $page->page_content !!}
            </div>
            @yield('after-content')
        </div>
    </div>
    @yield('after-body')
    <div id="pageData">
        <div id="slider">
            <div id="credentials">
                <div class="name">{!! $texts['HEADER-NAME'] !!}</div>
                <div class="rank">{!! $texts['HEADER-RANK'] !!}</div>
            </div>
        </div>
    </div>
@stop