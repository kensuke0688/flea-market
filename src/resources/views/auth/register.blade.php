<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <title>Coachtechフリマ</title>
</head>

<body>
    <header class="header">
        <img src="{{ asset('img/logo.svg') }}" alt="coachtech" width="240" height="80">
    </header>
    <div class="container">
        <div class="section-header">
            <h1 class="section-title">会員登録</h1>
        </div>

        <form class="register" action="/register" method="post">
            @csrf
            <div class="register-form">
                <h2 class="section-item">ユーザー名</h2>
                <input class="register-form__input" type="text" name="name" id="name">
                <p class="register-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form">
                <h2 class="section-item">メールアドレス</h2>
                <input class="register-form__input" type="text" name="email" id="email">
                <p class="register-form__error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form">
                <h2 class="section-item">パスワード</h2>
                <input class="register-form__input" type="password" name="password" id="password">
                <p class="register-form__error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form">
                <h2 class="section-item">確認用パスワード</h2>
                <input class="register-form__input" type="password" name="password_confirmation" id="password_confirmation">
                <p class="register-form__error-message">
                    @error('password_confirmation')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="register-form__btn-container">
                <input class="register-form__btn" type="submit" value="登録する">
            </div>
            <div class="login">
                <a class="login-form" href="/login">ログインはこちら</a>
            </div>
        </form>
    </div>
</body>

</html>

