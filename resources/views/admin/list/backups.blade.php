@extends('admin.list')

@section('headers')
    <h1>Резервные копии</h1>
    <h3 class="sub-header">Создание слепков сайта на случай восстановления</h3>
@stop

@section('items')
    <div class="preloader">
    </div>
    @if (sizeof($data))
        @include('admin.iteration.backup', ['items' => $data])
    @endif
@stop