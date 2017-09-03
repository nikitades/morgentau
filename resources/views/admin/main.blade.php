<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta id="initial_debug" content="{{( isset($debug) ? json_encode($debug) : '')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Администрирование')</title>
    <link rel="stylesheet" href="{{ elixir('css/admin.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.png">
    <script src="{{ elixir('js/admin.js') }}"></script>
    <script src="/js/ckeditor/ckeditor.js"></script>
    @yield('embed')
</head>
<body class="fixed-nav sticky-footer bg-dark{{ !empty($_COOKIE['admin-sidenav-toggled']) ? ' sidenav-toggled' : '' }}"
      id="page-top">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="/">{{ Lang::get('global.site-title') }}</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        @include('partials.sidebar')
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/logout">
                    <i class="fa fa-fw fa-sign-out"></i>
                    Выход</a>
            </li>
        </ul>
    </div>
</nav>
<div class="content-wrapper">
    <div class="container-fluid">
        @include('partials.admin-breadcrumbs')
        @yield('content')
    </div>
</div>
<footer class="sticky-footer">
    <div class="container">
        <div class="text-center">
            <small>Copyright &copy; <a href="https://github.com/nikitades">nikitades</a> 2017</small>
        </div>
    </div>
</footer>
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
</a>
</body>
</html>
