@extends('admin.list')

@section('title')
    Тексты сайта
@stop

@section('headers')
    <h4 class="sub-header">Список всех текстов для страниц сайта</h4>
    <a href="/admin/texts/new" class="buffer-25 btn btn-md btn-success">Добавить</a>
@stop

@section('items')
    @if (sizeof($data))
        <div class="items">
            @include('admin.iteration.text', ['items' => $data])
        </div>
    @endif
@stop