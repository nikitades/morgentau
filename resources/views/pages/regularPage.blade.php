@extends('app')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/regularPage.css') }}">
@stop

@section('content')
    @include('pages.partials.breadcrumbs')
    @yield('before-body')
    <h3>Page body</h3>
    <img src="https://i.ytimg.com/vi/prALrHUJ8Ns/hqdefault.jpg" alt="koteek">
    @yield('after-body')
@stop