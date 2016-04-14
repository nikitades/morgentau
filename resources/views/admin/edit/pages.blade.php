@extends('admin.edit')

@section('headers')
    <h1>{{ $type == 'create' ? 'Создание' : 'Редактирование' }} страницы, миу миу</h1>
    <h3 class="sub-header buffer-25">{{ $type == 'create' ? 'Задайте свойства создаваемой страницы' : 'Измените свойства редактируемой страницы' }}</h3>
@stop

@section('fields')
    <h2 class="buffer-25">{{ $item->name }}</h2>
    <div class="form-group">
        <div class="form-group" style="margin-left: 0;">
            {!! Form::label('is_active_visible', 'Видима?', ['class' => 'control-label col-sm-12']) !!}
            <div class="col-sm-12 input-holder">
                {!! Form::checkbox('is_active', 0, 1, ['class' => 'form-control hidden']) !!}
                {!! Form::checkbox('is_active', 1, $type == 'create' ? 1 : $item->is_active, ['id' => 'is_active_visible']) !!}
            </div>
        </div>
        <div class="form-group" style="margin-left: 0;">
            {!! Form::label('is_in_menu_visible', 'В меню', ['class' => 'control-label col-sm-12']) !!}
            <div class="col-sm-12 input-holder">
                {!! Form::checkbox('is_in_menu', 0, 1, ['class' => 'form-control hidden']) !!}
                {!! Form::checkbox('is_in_menu', 1, $type == 'create' ? 1 : $item->is_in_menu, ['id' => 'is_in_menu_visible']) !!}
            </div>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('parent', 'Предок', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::select('parent', $hierarchy->showList($item->parent, $item->id), $item->parent, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('view', 'Отображ.', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::select('view', $views, $item->view, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('name', 'Название', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('name', $item->name, ['class' => 'form-control', 'required' => 'required']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('header', 'Заголовок', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('header', $item->header, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('meta_tags', 'Теги', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('meta_tags', $item->meta_tags, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('meta_description', 'Описание', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('meta_description', $item->meta_description, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('url', 'Адрес', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('url', $item->url, ['class' => 'form-control', 'required' => 'required']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('page_content', 'Текст', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::textarea('page_content', $item->page_content, ['class' => 'form-control']) !!}</div>
    </div>
    @if(sizeof($images))
        <hr>
        @each('partials.attached-image', $images, 'images')
    @endif
    @if(sizeof($files))
        {{ sizeof($images) ? '' : '<hr>' }}
        @each('partials.attached-file', $files, 'files')
    @endif
    <script>
        $(document).ready(function () {
            CKEDITOR.replace('page_content');
        });
    </script>
@stop