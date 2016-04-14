@extends('pages.regularPage')

@section('embed')
    @parent
    <link rel="stylesheet" href="{{ elixir('css/contacts.css') }}">
@stop

@section('after-body')
    {!! $texts['MAP'] !!}
@stop