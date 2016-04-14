@extends('pages.regularPage')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/services.css') }}">
    <script src="/js/services.js"></script>
@stop

@section('after-content')
    <div class="news-list">
        <div class="services panel-group">
            @foreach($services as $service)
                <div class="panel panel-default service">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent=".services" href="#{{ $service->hash() }}">{{ $service->name }}</a>
                        </h4>
                    </div>
                    <div id="{{ $service->hash() }}" class="panel-collapse collapse">
                        <div class="panel-body">
                            {!!  $service->service_content !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop