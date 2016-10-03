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
        <form class="form-horizontal" role="form" method="POST" action="/register">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label class="col-md-4 control-label">Имя</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                </div>
            </div>

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
                <label class="col-md-4 control-label">Подтверждение пароля</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Зарегистрироваться
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>