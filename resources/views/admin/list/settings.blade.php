@extends('admin.list')

@section('headers')
    <h1>Настройки</h1>
    <h3 class="sub-header">Здесь можно изменить все управляемые администратором параметры</h3>
    <a href="/admin/settings/new" class="buffer-25 btn btn-md btn-success pull-left">Добавить</a>
@stop

@section('items')
    <table class="table list col-md-6 col-sm-12">
        <thead>
        <th width="1%"></th>
        <th width="25%">Название</th>
        <th width="25%">Код</th>
        <th width="1%" style="min-width: 124px;"></th>
        </thead>
        @foreach($data as $item)
            <tr>
                <td>
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </td>
                <td>
                    <a href="/admin/settings/{{ $item->id }}/edit">
                        {{ $item->name }}
                    </a>
                </td>
                <td>
                    <a href="/admin/settings/{{ $item->id }}/edit">
                        {{ $item->code }}
                    </a>
                </td>
                <td class="controls">
                    {!! Form::open(['action' => ['AdminController@move', 'settings', $item->id, 'up'], 'method' => 'get']) !!}
                    <button type="submit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-arrow-up"></i>
                    </button>
                    {!! Form::close() !!}
                    {!! Form::open(['action' => ['AdminController@move', 'settings', $item->id,  'down'], 'method' => 'get']) !!}
                    <button type="submit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-arrow-down"></i>
                    </button>
                    {!! Form::close() !!}
                    <a href="/admin/settings/{{ $item->id }}/edit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    {!! Form::open(['action' => ['SettingsController@destroy', $item->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
@stop