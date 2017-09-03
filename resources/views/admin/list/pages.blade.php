@extends('admin.list')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/admin-pages-list.css') }}">
@stop

@section('headers')
    <h4 class="sub-header">Список всех страниц сайта</h4>
    <a href="/admin/pages/new" class="buffer-25 btn btn-md btn-success">Добавить</a>
@stop

@section('items')
    <ul class="pages-list list-group entity-sortable entity-sortable-page">
        @if (!$tree[0])
            <li class="sortable-item">
                <div class="item-content">
                    <p>Ошибка! Нет элементов</p>
                </div>
            </li>
        @else
            @each('partials.treepage', $tree, 'page')
        @endif
    </ul>
@stop