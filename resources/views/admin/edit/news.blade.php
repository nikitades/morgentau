@extends('admin.edit')

@section('headers')
    <h1>{{ $type == 'create' ? 'Создание' : 'Редактирование' }} новости</h1>
    <h3 class="sub-header buffer-25">{{ $type == 'create' ? 'Внесите данные создаваемой новости' : 'Измените содержимое существующей новости' }}</h3>
@stop

@section('fields')
    <div class="form-group">
        {!! Form::label('title', 'Название', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('title', $item->title, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('date', 'Дата', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">
            {!! Form::input('date', 'date', $item->date, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('newsitem_url', 'Адрес', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('newsitem_url', $item->newsitem_url, ['class' => 'form-control', 'required' => 'required']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('full', 'Текст', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::textarea('full', $item->full, ['class' => 'form-control']) !!}</div>
    </div>
    @if(sizeof($images))
        <hr>
        @each('partials.attached-image', $images, 'images')
    @endif
    <script>
        $(document).ready(function () {
            CKEDITOR.replace('full');
        });
    </script>
@stop