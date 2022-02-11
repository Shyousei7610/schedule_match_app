<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログイン</title>
</head>
<body>
    <h2>ログインページです</h2>
    <form name="loginform" action="/login" method="post">
        {{ csrf_field() }}
    <dl>
        <dt>メールアドレス:</dt><dd><input type="text" name="email" size="30"></dd>
        <dt>パスワード:</dt><dd><input type="password" name="password" size="30"></dd>
    </dl>
    <button type="submit" name="action" value="send">ログイン</button>
    </form>
    <a href="{{ Route('signup') }}">新規登録</a>
</body>
</html>
