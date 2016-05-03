@extends('app')

@section('embed')
@stop

@section('content')
    <h1>{{ $texts['GREETING'] }}</h1>
        <div class="row">
            <div class="col-xs-12">
                @foreach ($arts as $art)
                    <h4>{{ $art->name }}</h4>
                    @if ($art->cover)
                        <img src="{{ $art->cover->source->url() }}" alt="{{ $art->cover->source->name }}">
                    @endif
                @endforeach
            </div>
        </div>
@stop