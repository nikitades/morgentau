@extends('admin.list')

@section('headers')
    <h1>Вопросы</h1>
    <h3 class="sub-header">Список вопросов, поступивших от пользователей сайта</h3>
    <a href="/admin/views/new" class="buffer-25 btn btn-md btn-success">Добавить</a>
@stop

@section('items')
    @if(sizeof($data))
        @include('admin.iteration.faq', ['items' => $data])
    @endif
@stop