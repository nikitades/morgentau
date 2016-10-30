@extends('admin.list')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/admin-pages-list.css') }}">
@stop

@section('headers')
    <h1>Страницы сайта</h1>
    <h3 class="sub-header">Список всех страниц сайта</h3>
    <a href="/admin/pages/new" class="buffer-25 btn btn-md btn-success">Добавить</a>
@stop

{{--//TODO: 2. Сделать контроллер новой сортировки 3. Сделать JS-функцию сортировки страниц--}}

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