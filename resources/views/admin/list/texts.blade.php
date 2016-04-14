@extends('admin.list')

@section('headers')
    <h1>Тексты сайта</h1>
    <h3 class="sub-header">Список всех текстов для страниц сайта</h3>
    <a href="/admin/texts/new" class="buffer-25 btn btn-md btn-success pull-left">Добавить</a>
@stop

@section('items')
    <table class="table list">
        <thead>
        <th width="1%"></th>
        <th width="25%">Название</th>
        <th width="25%">Код</th>
        <th width="25%">Содержание</th>
        <th width="1%" style="min-width: 124px;"></th>
        </thead>
        @foreach($data as $text)
            <tr>
                <td>
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </td>
                <td>{{ $text->name }}</td>
                <td>{{ $text->code }}</td>
                <td>
                    <div class="text_content"><pre>{{ (mb_strlen($text->text_content) > 45 ? (mb_substr($text->text_content, 0, 42).'...') : $text->text_content) }}</pre></div>
                </td>
                <td class="controls">
                    {!! Form::open(['action' => ['AdminController@move', 'texts', $text->id, 'up'], 'method' => 'get']) !!}
                    <button type="submit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-arrow-up"></i>
                    </button>
                    {!! Form::close() !!}
                    {!! Form::open(['action' => ['AdminController@move', 'texts', $text->id,  'down'], 'method' => 'get']) !!}
                    <button type="submit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-arrow-down"></i>
                    </button>
                    {!! Form::close() !!}
                    <a href="/admin/texts/{{ $text->id }}/edit" class="btn btn-xs btn-link">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    {!! Form::open(['action' => ['TextsController@destroy', $text->id], 'method' => 'delete']) !!}
                    <button type="submit" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>
@stop