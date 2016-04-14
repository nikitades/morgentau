<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <script src="{{ elixir('js/app.js') }}"></script>
    @yield('embed')
</head>
<body>
<div id="document" class="col-lg-10 col-md-12 col-lg-offset-1">
    <div id="content">
        @yield('content')
    </div>
    <div id="header">
        <div id="bar" class="clearfix">
            <div id="header-phones">
                <span class="icon"></span>
            </div>
            <div id="header-addresses">
                <span class="icon"></span>

            </div>
        </div>
        <div id="menu">
            @include('pages.partials.menu')
        </div>
    </div>
    <div id="footer" class="top-box">
        <div class="clearfix">
            <div class="address">

            </div>
            <div class="phones">
            </div>
        </div>
        <div id="copyrights">

        </div>
        <div id="author">
            <p>Создание сайта: <a href="mailto:pavlovskiy.nikita@gmail.com">morgentau</a></p>
        </div>
    </div>
</div>
</body>
</html>
