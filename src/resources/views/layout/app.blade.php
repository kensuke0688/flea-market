<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @yield('css')
</head>

<body>
    <header class="header">
        <img src="{{ asset('img/logo.svg') }}" alt="coachtech" width="240" height="80">
        <form class="search-form" action="{{ route('items.search') }}" method="GET">
            <input type="search" name="keyword" placeholder="なにをお探しですか?" value="{{ request('keyword') }}">
        </form>
        @guest
        <form class="form" action="/login" method="GET">
            <button class="login" type="submit">ログイン</button>
        </form>
        @endguest
        @if (Auth::check())
        <form class="form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout" type="submit">ログアウト</button>
        </form>
        @endif
        <form class="form" action="{{ route('mypage') }}" method="GET">
            <button class="mypage" type="submit">マイページ</button>
        </form>
        <form class="form" action="{{ route('item.sell') }}" method="GET">
            <button class="listing" type="submit">出品</button>
        </form>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>