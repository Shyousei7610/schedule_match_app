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
              <p>{{ $match_result->name }}</p>
              <p>{{ $match_result->schedule_date }}</p>
              <p>{{ $match_result->schedule_start_time }}</p>
              <p>{{ $match_result->schedule_end_time }}</p>
              <p>{{ $match_result->schedule_approval }}</p>
              <p>{{ $match_result->schedule_game_title }}</p>
              <p>{{ $match_result->personal }}</p>
              <p>{{ $match_result->schedule_detail }}</p>
              <form action="{{ route('match.apply') }}" method="post">
                @csrf
                <input type="hidden" name="schedule_number" value="{{ $schedule_number }}">
                <input type="hidden" name="partner_schedule_number" value="{{ $match_result->schedule_number }}">
                <input type="hidden" name="personal" value="{{ $personal }}">
                <input type="hidden" name="partner_pesonal" value="{{ $match_result->personal }}">
                <input type="submit" value="申請する">
              </form>
           @endforeach
        @else
        <p>マッチ相手がいません</p>
        @endif
    </div>
</body>
