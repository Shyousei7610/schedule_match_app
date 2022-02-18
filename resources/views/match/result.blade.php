<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>マッチ結果</title>
</head>
<body>
    <div>
        @if(! empty($schedule_match))
           @foreach ($schedule_match as $match_result)
              <p>{{ $match_result->schedule_date }}</p>
              <p>{{ $match_result->schedule_start_time }}</p>
              <p>{{ $match_result->schedule_end_time }}</p>
              <p>{{ $match_result->schedule_category }}</p>
              <p>{{ $match_result->area }}</p>
              <p>{{ $match_result->schedule_detail }}</p>
              <form action="{{ route('match.apply') }}" method="post">
                <input type="hidden" name="partner" value="{{ $match_result->schedule_id }}">
                <input type="hidden" name="partner_number" value="{{ $match_result->schedule_number }}">
                <input type="submit" value="申請する">
              </form>
           @endforeach
        @else
        <p>マッチ相手がいません</p>
        @endif
    </div>
</body>
