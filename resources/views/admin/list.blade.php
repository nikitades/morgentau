@extends('admin.main')

@section('content')
    @yield('headers')
    @include('partials.errors')
    @yield('items')
@stop


