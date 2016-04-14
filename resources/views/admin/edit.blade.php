@extends('admin.main')

@section('content')
    @yield('headers')
    @include('partials.errors')
    {!! Form::open(['action' => $action, 'method' => $method, 'class' => 'form-horizontal', 'role' => 'form', 'files' => 'true']) !!}
    <div class="editing-fields">
        @yield('fields')
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <input type="hidden" name="current_url" value="{{ $_SERVER['REQUEST_URI'] }}">
            <button class="btn btn-success btn-md" name="direction" value="back">Сохранить и назад</button>
            @if ($type == 'edit')
            <button class="btn btn-success btn-md" name="direction" value="stay">Сохранить</button>
            @endif
            <a href="/admin/{{ $entity }}" class="btn btn-default btn-md">Назад</a>
        </div>
    </div>
    {!! Form::close() !!}
@stop