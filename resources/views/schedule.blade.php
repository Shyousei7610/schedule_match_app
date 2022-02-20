<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スケジュール</title>
</head>
<body>
    <h2>スケジュールページです</h2>
    <a href="{{ route('home') }}">ホーム</a>
    @if (!empty($schedules))
    <div>
        @foreach ($schedules as $schedules_key => $schedule)
            @foreach ($schedule as $key => $value)

                @if($key == 'schedule_number')
                <form name="delete_form" action="{{ route('schedule.delete') }}" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="schedule_number" value="{{ $value }}">
                    <input type="submit" value="削除する">
                </form>
                <form name="match-form" action="{{ route('match.search') }}" method="get">
                    <input type="hidden" name="schedule_number" value="{{ $value }}">
                    <input type="submit" value="マッチする">
                </form>
                @continue($key == 'schedule_number')
                @endif

               <div>
                 <p>
                    <ul>
                        <li>{{ $value }}</li>
                   </ul>
                 </p>
                </div>

            @endforeach
        @endforeach
    </div>
    @else
    <div>
        <p>予定の登録はありません</p>
    </div>
    @endif
</body>
