@extends('app')

@section('embed')
    <link rel="stylesheet" href="{{ elixir('css/faq.css') }}">
@stop

@section('content')
    <div id="article">
        <div class="holder">
            <h1>{{ $page->header }}</h1>
            <div class="body">
                {!! $page->page_content !!}
                <div class="faq-form">
                    <div class="holder">
                        {!! Form::open(['action' => 'FaqController@store', 'role' => 'form']) !!}
                        <p class="label">Задайте свой вопрос нотариусу</p>
                        {!! Form::text('name', null, ['placeholder' => 'Ваше имя']) !!}
                        {!! Form::email('email', null, ['placeholder' => 'Ваше электронная почта']) !!}
                        {!! Form::textarea('message', null, ['placeholder' => 'Сообщение (обязательно)', 'required' => 'required']) !!}
                        {!! Form::submit() !!}
                        {!! Form::close() !!}
                    </div>
                    @include('partials.errors')
                </div>
                <div class="faq-answers">
                    <ul class="faq-answers--list">
                        @foreach($answers as $answer)
                            <li class="faq-answers--answer">
                                <p class="faq-answers--question">
                                    {{ $answer->message }}
                                </p>
                                <p class="faq-answers--answer-text">
                                    {{ $answer->answer }}

                                    <span class="faq-answers--sub">{{ $texts['FAQ-SUB'] }}</span>
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="pageData">
        <div id="slider">
            <div id="credentials">
                <div class="name">{!! $texts['HEADER-NAME'] !!}</div>
                <div class="rank">{!! $texts['HEADER-RANK'] !!}</div>
            </div>
        </div>
    </div>
@stop