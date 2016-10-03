@extends('admin.list')

@section('headers')
    <h1>Вопросы</h1>
    <h3 class="sub-header">Список вопросов, поступивших от пользователей сайта</h3>
    <a href="/admin/views/new" class="buffer-25 btn btn-md btn-success pull-left">Добавить</a>
@stop

@section('items')
    <table class="table list">
        <thead>
        <th width="1%"></th>
        <th width="25%">Имя</th>
        <th>Вопрос</th>
        <th width="1%" style="min-width: 68px;"></th>
        </thead>
        @foreach($data as $item)
            <tr>
                <td>
                    <span class="glyphicon glyphicon-{{ $item->answered ? 'ok' : 'remove' }}" aria-hidden="true"></span>
                </td>
                <td>{{ $item->name }}</td>
                <td>
                    <a href="/admin/faq/{{ $item->id }}/edit">
                        {{ mb_strlen($item->message) > 50 ? mb_substr($item->message, 0, 47).'...' : $item->message }}
                    </a>
                </td>
                <td class="controls">
                    <a href="/admin/faq/{{ $item->id }}/edit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    {!! Form::open(['action' => ['FaqController@destroy', $item->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
@stop