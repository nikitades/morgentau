@extends('admin.edit')

@section('headers')
    <h1>{{ $type == 'create' ? 'Создание' : 'Редактирование' }} отображения</h1>
    <h3 class="sub-header buffer-25">{{ $type == 'create' ? 'Задайте свойства создаваемого отображения' : 'Измените свойства редактируемого отображения' }}</h3>
@stop

@section('fields')
    <div class="form-group">
        {!! Form::label('name', 'Название', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('name', $item->name, ['class' => 'form-control']) !!}</div>
    </div>
    <div class="form-group">
        {!! Form::label('view', 'View', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::text('view', $item->view, ['class' => 'form-control']) !!}</div>
    </div>
@stop