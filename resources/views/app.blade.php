<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="initial_debug" content="{{( isset($debug) ? json_encode($debug) : '')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.png">
    @include('partials.title')
    <script src="{{ elixir('js/app.js') }}"></script>
    @yield('embed')
</head>
<body>
<div id="header" class="container">
    <div class="row">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{ $_ENV['PROJECT_NAME'] }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                @include('pages.partials.menu')
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
@yield('precontent')
<div id="document" class="container">
    <div class="row">
        <div id="content" class="col-xs-12">
            @yield('content')
        </div>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>
