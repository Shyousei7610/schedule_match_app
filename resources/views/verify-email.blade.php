<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>メール確認</title>
</head>
<body>
    <h1>メール確認しろ!!</h1>
    <form action="{{ Route('verification.send') }}" method="post">
        {{ csrf_field() }}
        <button type="submit" name="action" value="send">メール再送信</button>
    </form>
</body>
</html>
