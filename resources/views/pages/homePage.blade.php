@extends('app')

@section('embed')
@stop

@section('content')
    <h1>{{$page->header}}</h1>
    <p>{!! $page->page_content !!}</p>
@stop