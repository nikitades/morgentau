@extends('admin.list')

@section('headers')
    <h1>Отображения страниц</h1>
    <h3 class="sub-header">Отображение - это файл, заключающий в себе то, как будет выглядеть эта страница на сайте</h3>
    <a href="/admin/views/new" class="buffer-25 btn btn-md btn-success pull-left">Добавить</a>
@stop

@section('items')
    <table class="table list">
        <thead>
        <th width="1%"></th>
        <th width="25%">Название</th>
        <th>Отображение</th>
        <th width="1%" style="min-width: 124px;"></th>
        </thead>
        @foreach($data as $view)
            <tr>
                <td>
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </td>
                <td>{{ $view->name }}</td>
                <td>{{ $view->view }}</td>
                <td class="controls">
                    {!! Form::open(['action' => ['AdminController@move', 'views', $view->id, 'up'], 'method' => 'get']) !!}
                    <button type="submit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-arrow-up"></i>
                    </button>
                    {!! Form::close() !!}
                    {!! Form::open(['action' => ['AdminController@move', 'views', $view->id,  'down'], 'method' => 'get']) !!}
                    <button type="submit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-arrow-down"></i>
                    </button>
                    {!! Form::close() !!}
                    <a href="/admin/views/{{ $view->id }}/edit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    {!! Form::open(['action' => ['ViewsController@destroy', $view->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
@stop