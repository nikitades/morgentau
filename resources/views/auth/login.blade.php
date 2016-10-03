<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Авторизация</title>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
</head>
<body>
<div class="container">
    <div class="col-xs-8 col-xs-offset-2 buffer-50">
        <form class="form-horizontal" role="form" method="POST" action="/login">
            {{ csrf_field() }}

            <div class="form-group">
                <label class="col-md-4 control-label">Электронная почта</label>
                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Пароль</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Запомнить
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                        Вход
                    </button>

                    <a href="/password/email">Забыли пароль?</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>