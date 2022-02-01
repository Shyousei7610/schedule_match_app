<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ホーム</title>
</head>
<body>
    <h2>ホームページです。アカウントの予定などを示す。</h2>
    @if (!empty($auth_result))
    <h4>ログインは{{ $auth_result }}です</h4>
    @endif
    @if (Auth::check())
    <p>{{ Auth::user()->name, }}さん、ログインしています</p>
    @else
    <p>ログインしていません</p>
    <a href="{{ Route('login') }}">ログイン</a>
    @endif
    <a href="{{ Route('logout') }}">ログアウト</a>
</html>
