<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.png">
    <script src="{{ elixir('js/app.js') }}"></script>
    @yield('embed')
</head>
<body>
<div id="document" class="container">
    <div id="header" class="col-xs-12">
        <div id="menu" class==col-xs-12>
            @include('pages.partials.menu')
        </div>
    </div>
    <div id="content">
        @yield('content')
    </div>
    <div id="footer">
    </div>
</div>
</body>
</html>
