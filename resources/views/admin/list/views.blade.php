@extends('admin.list')

@section('headers')
    <h4 class="sub-header">Отображение - это шаблон страницы</h4>
    <a href="/admin/views/new" class="buffer-25 btn btn-md btn-success">Добавить</a>
@stop

@section('items')
    @if (sizeof($data))
        <div class="items">
            @include('admin.iteration.view', ['items' => $data])
        </div>
    @else
        <h2>Нет элементов :С</h2>
    @endif
@stop