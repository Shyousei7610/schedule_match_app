<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ホーム</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div>
        <h2 class="text-red-200 font-bold underline">ホームページです。アカウントの予定などを示す。</h2>
        @if (!empty($auth_result))
        <h4>ログインは{{ $auth_result }}です</h4>
        @endif

        @if (Auth::check())
        <p>{{ Auth::user()->name, }}さん、ログインしています</p>
        <a href="{{ Route('profile') }}">プロフィール</a>
        <a href="{{ Route('schedule.list') }}">スケジュール</a>
        <a href="{{ Route('logout') }}">ログアウト</a>
        @else
        <p>ログインしていません</p>
        <a href="{{ Route('login') }}">ログイン</a>
        @endif
    </div>
</body>
</html>
