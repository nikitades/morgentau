@extends('admin.list')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/admin-pages-list.css') }}">
@stop

@section('headers')
    <h1>Страницы сайта</h1>
    <h3 class="sub-header">Список всех страниц сайта</h3>
    <a href="/admin/pages/new" class="buffer-25 btn btn-md btn-success">Добавить</a>
@stop

@section('items')
    <ul class="pages-table">
        <li class="item header">
            <div class="item--icon">

            </div>
            <div class="item--name">
                <p>Название</p>
            </div>
            <div class="item--view">
                <p>Отображение</p>
            </div>
            <div class="item--url">
                <p>Адрес</p>
            </div>
            <div class="item--controls">
            </div>
        </li>
        @if (!$tree[0])
                <li class="item header">
                    <div class="item--icon">
        <span class="glyphicon glyphicon-exclamation-sign"
              aria-hidden="true"></span>
                    </div>
                    <div class="item--name">
                        <p>Ошибка! Нет элементов</p>
                    </div>
                    <div class="item--view">

                    </div>
                    <div class="item--url">

                    </div>
                    <div class="item--controls">

                    </div>
                </li>
        @else
            @each('partials.treepage', $tree, 'page')
        @endif
    </ul>
@stop