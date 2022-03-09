<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>スケジュール</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="m-0 bg-white">
    <header class="border-b">
        <div class="flex w-750px mx-auto">
            <div class="w-70px text-center"><a href="{{ route('home') }}">ホーム</a></div>
            <div class="grow"></div>
            <div class="w-70px text-center"><a href="{{ route('schedule.list') }}">予定</a></div>
            <div class="w-70px text-center"><a href="{{ route('profile') }}">プロフィール</a></div>
        </div>
    </header>
    <h2 class="text-center">スケジュールページです</h2>
    <div class="flex justify-center min-h-1080px">
    <div></div>
    <div class="mx-auto w-650px border-x border-slate-400 min-h-1080px">
        <a href="{{ route('schedule.register') }}">新規登録</a>
    @if (! empty($schedules))
        @foreach ($schedules as $schedule)
         <div class="border-y border-slate-400 w-full">
         <div>
               <div>
                 <p>
                    <ul>
                        <li>{{ $schedule->schedule_date }}</li>
                        <li>{{ $schedule->schedule_start_time }}</li>
                        <li>{{ $schedule->schedule_end_time }}</li>
                        <li>{{ $schedule->schedule_approval }}</li>
                        <li>{{ $schedule->schedule_game_title }}</li>
                        <li>{{ $schedule->schedule_detail }}</li>
                   </ul>
                 </p>
                </div>
                <form name="match-form" action="{{ route('match.match') }}" method="get">
                    <input type="hidden" name="schedule_number" value="{{ $schedule->schedule_number }}">
                    <input type="submit" value="マッチする">
                </form>
                <form name="delete_form" action="{{ route('schedule.delete') }}" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="schedule_number" value="{{ $schedule->schedule_number }}">
                    <input type="submit" value="削除する">
                </form>
         </div>
         </div>
        @endforeach
    </div>
    @elseif ($schedules == false)
        <p>予定の登録はありません</p>
    </div>
    @endif
    <div></div>
    </div>
</body>
