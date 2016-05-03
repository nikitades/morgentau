@extends('admin.edit')

@section('headers')
    <h1>{{ $type == 'create' ? 'Создание' : 'Редактирование' }} объекта</h1>
@stop

@section('fields')
    <div class="form-group">
        {!! Form::label('is_active_visible', 'Видим', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-10 input-holder">
            {!! Form::checkbox('is_active', 0, 1, ['class' => 'form-control hidden']) !!}
            {!! Form::checkbox('is_active', 1, $type == 'create' ? 1 : $item->is_active, ['id' => 'is_active_visible']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Название', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('name', $item->name, ['class' => 'form-control', 'required' => 'required']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('publish_date', 'Дата', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">
            {!! Form::date('publish_date', $item->publish_date, ['class' => 'form-control', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('artwork_url', 'Адрес', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('artwork_url', $item->artwork_url, ['class' => 'form-control', 'required' => 'required']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('page_content', 'Текст', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::textarea('page_content', $item->page_content, ['class' => 'form-control']) !!}</div>
    </div>
    @if(sizeof($images))
        <hr>
        @each('partials.attached-image', $images, 'images')
    @endif

    <script>
        $(document).ready(function () {
            CKEDITOR.replace('page_content');
            $('[name="publish_date"]').keypress(function (e) { return false; });
        });
    </script>
@stop