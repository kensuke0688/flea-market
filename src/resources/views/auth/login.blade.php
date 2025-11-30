<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Coachtechフリマ</title>
</head>

<body>
    <header class="header">
        <img src="{{ asset('img/logo.svg') }}" alt="coachtech" width="240" height="80">
    </header>

    <div class="container">
        <div class="section-header">
            <h1 class="section-title">ログイン</h1>
        </div>

        <form class="login" action="/login" method="post">
            @csrf
            <div class="login-form">
                <h2 class="section-item">メールアドレス</h2>
                <input class="login-form__input" type="text" name="email" id="email" >
                <p class="login-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="login-form">
                <h2 class="section-item">パスワード</h2>
                <input class="login-form__input" type="password" name="password" id="password">
                <p class="login-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="login-form__btn-container">
                <input class="login-form__btn" type="submit" value="ログインする">
            </div>
            <div class="register">
                <a class="register-form" href="/register">会員登録はこちら</a>
            </div>
        </form>
    </div>
</body>

</html>