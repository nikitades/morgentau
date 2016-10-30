@extends('admin.list')

@section('headers')
    <h1>Настройки</h1>
    <h3 class="sub-header">Здесь можно изменить все управляемые администратором параметры</h3>
    <a href="/admin/settings/new" class="buffer-25 btn btn-md btn-success">Добавить</a>
@stop

@section('items')
    @if (sizeof($data))
        <div class="items">
            @include('admin.iteration.setting', ['items' => $data])
        </div>
    @endif
@stop