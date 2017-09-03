@extends('admin.edit')

@section('headers')
    <h1>{{ $type == 'create' ? 'Создание' : 'Редактирование' }} текста сайта</h1>
    <h3 class="sub-header buffer-25">{{ $type == 'create' ? 'Укажите содержание текстовой записи' : 'Измение содержание текстовой записи' }}</h3>
@stop

@section('fields')
    <div class="form-group">
        {!! Form::label('name', 'Название', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('name', $item->name, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('code', 'Код', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('code', $item->code, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('html', 'Wysiwyg', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-11 input-holder">
            {!! Form::checkbox('html', 1, $type == 'create' ? 1 : $item->html, ['id' => 'html']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('text_content', 'Содержимое', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::textarea('text_content', $item->text_content, ['class' => 'form-control']) !!}</div>
    </div>
    @if ($item->html)
    <script>
        $(document).ready(function () {
            CKEDITOR.replace('text_content');
        });
    </script>
    @endif
@stop