@extends('admin.list')

@section('headers')
    <h1>Новости</h1>
    <h3 class="sub-header">Список всех новостей сайта</h3>
    <a href="/admin/news/new" class="buffer-25 btn btn-md btn-success pull-left">Добавить</a>
@stop

@section('items')
    <table class="table list">
        <thead>
        <th width="1%"></th>
        <th width="3%">Дата</th>
        <th width="20%">Название</th>
        <th width="1%" style="min-width: 72px;"></th>
        </thead>
        @foreach($data as $newsItem)
            <tr>
                <td>
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </td>
                <td>
                    {{ App\Date::fullDate($newsItem->date) }}
                </td>
                <td>
                    <a href="/admin/news/{{ $newsItem->id }}/edit">
                        {{ $newsItem->title }}
                    </a>
                </td>
                <td class="controls">
                    <div>
                        <a href="/news/{{ $newsItem->id }}/hot" class="btn btn-xs btn-link">
                            <i class="glyphicon glyphicon-star{{ $newsItem->hot ? '' : '-empty' }}"></i>
                        </a>
                        <a href="/admin/news/{{ $newsItem->id }}/edit" class="btn btn-xs btn-link">
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                        <a href="/news/{{ $newsItem->id }}/delete" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
@stop