<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Авторизация</title>
    <link rel="stylesheet" href="{{ elixir('css/admin.css') }}">
</head>
<body class="bg-dark">
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">
            Авторизация
        </div>
        <div class="card-body">
            <form method="POST" action="/login">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                           placeholder="ivan@divan.ru">
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Пароль">
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="remember">
                            Запомнить
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Вход
                </button>
            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="/register">Зарегистрироваться</a>
                {{--<a class="d-block small" href="forgot-password.html">Forgot Password?</a>--}}
            </div>
        </div>
    </div>
</div>
</body>
</html>
