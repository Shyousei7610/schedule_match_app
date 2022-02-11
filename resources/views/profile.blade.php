<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>マイプロフィール</title>
</head>
<body>
    <div>
        {{ $profile_introduction }}
        <img src = "{{ asset('storage/'.$profile_icon)}}">
        <img src = "{{ asset('storage/'.$profile_header)}}">
    </div>

    <div>
    <form action="/profile" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <input type="text" name="profile_introduction">
        <span>{{ $errors->first('profile_introduction') }}</span>
        <input type="file" name="profile_icon">
        <input type="file" name="profile_header">
    <input type="submit" value="アップロードする">
    </form>
    </div>

</body>
</html>
