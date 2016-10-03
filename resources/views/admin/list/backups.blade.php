@extends('admin.list')

@section('headers')
    <h1>Резервные копии</h1>
    <h3 class="sub-header">Создание слепков сайта на случай восстановления</h3>
@stop

@section('items')
    <div class="preloader">

    </div>
    <table class="table list buffer-50">
        <thead>
        <th width="1%"></th>
        <th width="8%">Дата</th>
        <th width="5%">Размер</th>
        <th width="20%">Тип</th>
        <th width="1%" style="min-width: 72px;"></th>
        </thead>
        @foreach($data as $backup)
            <tr>
                <td>
                    <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                </td>
                <td>
                    {{ App\Date::fullDate($backup->created_at) }}, {{ date('H:i:s', strtotime($backup->created_at)) }}
                </td>
                <td>
                    {{ number_format($backup->size / 1024 / 1024, 2, '.', ' ') }} Мб
                </td>
                <td>
                    {{ $backup->hrType() }}
                </td>
                <td class="controls">
                    <div>
                        <a href="/backups/{{ $backup->id }}/restore" onclick="if (confirm('Вы уверены?')) {$('.preloader').fadeIn(); } else {return false;}" class="btn btn-xs btn-link">
                            <i class="glyphicon glyphicon-repeat "></i>
                        </a>
                        <a href="/backups/{{ $backup->id }}/delete" onclick="return confirm('Вы уверены?')" class="btn btn-xs btn-link red">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="col-sm-12 no-padding">
        <a href="/backups/all" onclick="if (confirm('Вы уверены?')) {$('.preloader').fadeIn(); } else {return false;}" class="btn btn-md btn-success">
            <i class="glyphicon glyphicon-save-file "></i>
            Полный слепок
        </a>
        <a href="/backups/base" onclick="if (confirm('Вы уверены?')) {$('.preloader').fadeIn(); } else {return false;}" class="btn btn-md btn-success">
            <i class="glyphicon glyphicon-save-file "></i>
            Только база
        </a>
        <a href="/backups/files" onclick="if (confirm('Вы уверены?')) {$('.preloader').fadeIn(); } else {return false;}" class="btn btn-md btn-success">
            <i class="glyphicon glyphicon-save-file "></i>
            Только файлы сайта
        </a>
    </div>
@stop