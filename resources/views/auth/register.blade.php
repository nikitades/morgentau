<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Регистрация</title>
    <link rel="stylesheet" href="{{ elixir('css/admin.css') }}">
</head>
<body class="bg-dark">
<div class="container">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">
            Регистрация
        </div>
        <div class="card-body">
            <form method="POST" action="/register">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" id="name"
                                   placeholder="Иван Диван"
                                   name="name" value="{{ old('name') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Электронная почта</label>
                    <input type="email" class="form-control" id="email"
                           placeholder="ivan@divan.ru"
                           name="email" value="{{ old('email') }}"
                    >
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password"
                                   name="password"
                                   placeholder="Пароль">
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Подтверждение пароля</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Еще раз">
                        </div>
                    </div>
                </div>
                @include('partials.errors')
                <button type="submit" class="btn btn-primary btn-block">
                    Зарегистрироваться
                </button>
            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="/login">Войти</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>