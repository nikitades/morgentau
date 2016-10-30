@extends('admin.list')

@section('headers')
    <h1>Новости</h1>
    <h3 class="sub-header">Список всех новостей сайта</h3>
    <a href="/admin/news/new" class="buffer-25 btn btn-md btn-success">Добавить</a>
    <div class="clearfix"></div>
@stop

@section('items')
    @if(sizeof($data))
        @include('admin.iteration.newsitem', ['items' => $data])
    @endif
@stop