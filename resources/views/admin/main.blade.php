<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=10, maximum-scale=1">
    <title>Администрирование</title>
    <link rel="stylesheet" href="{{ elixir('css/admin.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.png">
    <script src="{{ elixir('js/admin.js') }}"></script>
    <script src="/ckeditor/ckeditor.js"></script>
    @yield('embed')
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{{ Lang::get('global.site-title') }}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/logout">{{ trans('global.exit') }}</a></li>
            </ul>
        </div>
    </div>
</nav>
<div id="content">
    @include('partials.sidebar')
    <div class="col-sm-8 main">
        @if (isset($title))
            <h1>{{ $title }}</h1>
        @endif
        @yield('content')
    </div>
</div>
</body>
</html>