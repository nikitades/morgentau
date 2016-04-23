@extends('admin.edit')

@section('headers')
    <h1>{{ $type == 'create' ? 'Создание' : 'Редактирование' }} параметра</h1>
    <h3 class="sub-header buffer-25">{{ $type == 'create' ? 'Задайте свойства создаваемой настройки' : 'Измените свойства редактируемой настройки' }}</h3>
@stop

@section('fields')
    <div class="form-group">
        {!! Form::label('name', 'Название', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">
            {!! Form::text('name', $item->name, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('code', 'Код', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">
            {!! Form::text('code', $item->code, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('type', 'Тип', ['class' => 'control-label col-sm-12']) !!}
        <div class="col-sm-12">{!! Form::select('type', $item->types(), $item->type, ['class' => 'form-control']) !!}</div>
    </div>
    @if ($type == 'edit')
        @if ($item->type == 'string')
            <div class="form-group">
                {!! Form::label('value', 'Значение', ['class' => 'control-label col-sm-12']) !!}
                <div class="col-sm-12">{!! Form::text('value', $item->value, ['class' => 'form-control']) !!}</div>
            </div>
        @endif
        @if ($item->type == 'boolean')
            <div class="form-group">
                {!! Form::label('value_visible', 'Значение', ['class' => 'control-label col-sm-12']) !!}
                <div class="col-sm-11 input-holder">
                    {!! Form::checkbox('value', 0, 1, ['class' => 'form-control hidden']) !!}
                    {!! Form::checkbox('value', 1, $item->value, ['id' => 'value_visible']) !!}
                </div>
            </div>
        @endif
        @if ($item->type == 'text')
            <div class="form-group">
                {!! Form::label('value', 'Текст', ['class' => 'control-label col-sm-12']) !!}
                <div class="col-sm-12">{!! Form::textarea('value', $item->value, ['class' => 'form-control']) !!}</div>
            </div>
            <script>
                $(document).ready(function () {
                    CKEDITOR.replace('value');
                });
            </script>
        @endif
    @endif
@stop