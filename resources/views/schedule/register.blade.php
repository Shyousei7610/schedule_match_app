<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>予定の登録</title>
</head>
<body>
    <h2>予定の登録</h2>
    <form name="loginform" action="/schedule/register" method="post">
        {{ csrf_field() }}
        <input type="date" name="schedule_date">
        <input type="time" name="schedule_start_time">
        <input type="time" name="schedule_end_time">
        <input type="text" name="schedule_game_title">
        <select name="schedule_approval">
            <option>誰でもOK</option>
            <option>承認制</option>
        </select>
        <input type="text" name="schedule_detail">
        <input type="submit" value="登録する">
    </form>
</body>
</html>
