<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://geoapi.heartrails.com/api/geoapi.js"></script>
    <title>予定の登録</title>
</head>
<body>
    <h2>予定の登録</h2>
    <form name="loginform" action="/register" method="post">
        {{ csrf_field() }}
        <input type="date" name="schedule_date">
        <input type="time" name="schedule_start_time">
        <input type="time" name="schedule_end_time">
        <select name="schedule_category">
            <option value="買い物">買い物</option>
            <option value="スポーツ">スポーツ</option>
            <option value="視聴鑑賞">視聴鑑賞</option>
            <option value="街ブラ">街ブラ</option>
            <option value="料理食事">料理食事</option>
            <option value="楽器音楽">楽器音楽</option>
            <option value="ゲーム">ゲーム</option>
            <option value="その他">オンライン</option>
            <option value="その他">その他</option>
        </select>
        <select id="geoapi-prefectures" name="schedule_prefectures">
            <option value="都道府県を選択してください">都道府県を選択してください</option>
          </select>
          <select id="geoapi-cities" name="schedule_cities">
            <option value="市区町村名を選択してください">市区町村名を選択してください</option>
          </select>
          <select id="geoapi-towns" name="schedule_towns">
            <option value="町域を選択してください">町域を選択してください</option>
          </select>
        <input type="text" name="schedule_detail">
        <input type="submit" value="登録する">
    </form>
</body>
</html>
