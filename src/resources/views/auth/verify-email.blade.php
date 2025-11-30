<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
    <title>Coachtechフリマ</title>
</head>

    <body>
        <header class="header">
            <img src="{{ asset('img/logo.svg') }}" alt="coachtech" width="240" height="80">
        </header>

        <div class="verify-container">
            <div class="verify-inner">
                <p class="verify-message">
                    登録していただいたメールアドレスに認証メールを送付しました。<br>
                    メール認証を完了してください。
                </p>

                <a href="https://mailtrap.io/inboxes/3021529/messages/5195444421"
                    target="_blank"
                    class="btn btn-gray">
                    認証はこちらから
                </a>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-link">
                        認証メールを再送する
                    </button>
                </form>

                @if (session('message'))
                <p class="resend-message">
                    {{ session('message') }}
                </p>
                @endif
            </div>
        </div>
    </body>

    </html>
</body>

</html>