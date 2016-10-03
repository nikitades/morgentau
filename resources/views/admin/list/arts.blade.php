@extends('admin.list')

@section('headers')
    <h1>Объекты искусства</h1>
    <a href="/admin/arts/new" class="buffer-25 btn btn-md btn-success pull-left">Добавить</a>
    <div class="clearfix"></div>
@stop

@section('items')
    <table class="table list">
        <thead>
        <th width="1%"></th>
        <th width="3%">Дата</th>
        <th width="20%">Название</th>
        <th width="2%" style="min-width: 72px;"></th>
        </thead>
        @foreach($data as $item)
            <tr>
                <td>
                    <span class="glyphicon glyphicon-file {{ $item->is_active ? '' : 'page_not_active' }}"
                          aria-hidden="true"></span>
                </td>
                <td>
                    <a href="/admin/arts/{{ $item->id }}/edit">
                        {{ App\Date::fullDate($item->publish_date) }}
                    </a>
                </td>
                <td>
                    <a href="/admin/arts/{{ $item->id }}/edit">
                        {{ $item->name }}
                    </a>
                </td>
                <td class="controls">
                    <div>
                        <a href="/arts/{{ $item->id }}/hot" class="btn btn-xs btn-link">
                            <i class="glyphicon glyphicon-star{{ $item->hot ? '' : '-empty' }}"></i>
                        </a>
                        <a href="/admin/arts/{{ $item->id }}/edit" class="btn btn-xs btn-link">
                            <i class="glyphicon glyphicon-edit"></i>
                        </a>
                        <a href="/arts/{{ $item->id }}/delete" onclick="return confirm('Вы уверены?')"
                           class="btn btn-xs btn-link red">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
@stop