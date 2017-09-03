@extends('admin.main')

@section('title')
    {{$title}}
@stop

@section('content')
    @yield('headers')
    @include('partials.errors')
    @yield('items')
@stop


