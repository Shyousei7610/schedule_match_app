<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Matches;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Library\UserSchedule;

class MatchController extends Controller
{
    use UserSchedule;

    public function indexResult(){
        return view('match.result',[]);
    }

    public function match(Request $request){
        $user_schedule = $this->getSchedule($request);

        $schedule_query = Schedule::leftJoin('users', 'users.id', '=', 'schedules.schedule_id')
                              ->leftJoin('matches', 'matches.match_number', '=', 'schedules.schedule_number')
                              ->select('schedule_number', 'schedule_date', 'schedule_game_title', 'schedule_approval', 'schedule_start_time', 'schedule_end_time', 'name', 'personal', 'match_status')
                              ->whereNotIn('match_result', [true])
                              ->whereNotIn('match_partner_number', [$request->schedule_number])
                              ->where('match_status', null)
                              ->where('schedule_id', '<>',[$user_schedule['schedule_id']])
                              ->whereDate('schedule_date', $user_schedule['schedule_date'])
                              ->where('schedule_game_title', $user_schedule['schedule_game_title'])
                              ->whereTime('schedule_start_time', '>=', $user_schedule['schedule_start_time'])
                              ->whereTime('schedule_end_time', '<=', $user_schedule['schedule_end_time']);


        $schedule_count = $schedule_query->count();

        if($schedule_count >= 5){
            $schedule_match = $schedule_query->get();

            return view('match.index',['schedule_match' =>  $schedule_match, 'schedule_number' => $request->schedule_number, 'personal' => $user_schedule['personal']]);

        }elseif($schedule_count < 5){

            $time_range = '2hours';
            $time_start = date('H:i', strtotime($user_schedule['schedule_start_time']."-".$time_range));
            $time_end = date('H:i', strtotime($user_schedule['schedule_end_time']."+".$time_range));

            $schedule_query = Schedule::leftJoin('users', 'users.id', '=', 'schedules.schedule_id')
                                      ->leftJoin('matches', 'matches.match_number', '=', 'schedules.schedule_number')
                                      ->select('schedule_number', 'schedule_date', 'schedule_game_title', 'schedule_approval', 'schedule_start_time', 'schedule_end_time', 'name', 'personal', 'match_status')
                                      ->where('schedule_id', '<>',[$user_schedule['schedule_id']])
                                      ->whereNotIn('match_result', [true])
                                      ->whereDate('schedule_date', $user_schedule['schedule_date'])
                                      ->where('schedule_game_title', $user_schedule['schedule_game_title'])
                                      ->whereTime('schedule_start_time', '>=', $time_start)
                                      ->whereTime('schedule_end_time', '<=', $time_end);
        }

        if($schedule_query->exists()) {
            $schedule_match = $schedule_query->get();
            return view('match.index',['schedule_match' =>  $schedule_match, 'schedule_number' => $request->schedule_number, 'personal' => $user_schedule['personal']]);
        } elseif(! $schedule_query->exists()) {
            $match_result = 'マッチする相手が見つかりませんでした';
            return view('match.index',['match_result' => $match_result]);
        }

        return redirect(route('schedule'));
    }

    public function apply(Request $request) {

        $result1 = Matches::where('match_number', $request->schedule_number)
                          ->where('match_partner_number', $request->partner_schedule_number);



        if($result1->exists()) {

        } else {


        $chat_identifier = Str::uuid();

        Matches::create([
            'match_number' => $request->schedule_number,
            'match_partner_number' => $request->partner_schedule_number,
            'match_status' => true,
            'match_result' => null,
        ]);

        Chat::create([
            'chat_identifier' => $chat_identifier,
            'chat_sender' => $request->personal,
            'chat_reciever' => $request->partner_personal,
            'chat_text' => null
        ]);
    }

        return redirect("/message/${chat_identifier}");
    }

}


