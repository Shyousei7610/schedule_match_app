<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Matches;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function indexResult(){
        return view('match.result',[]);
    }

    public function search(Request $request){
        $user_schedule = $this->getSchedule($request);


        foreach($user_schedule as $schedule){
            $schedule_id = $schedule->schedule_id;
            $date = $schedule->schedule_date;
            $category = $schedule->schedule_category;
            $area = $schedule->schedule_area;
            $time_start = $schedule->schedule_start_time;
            $time_end = $schedule->schedule_end_time;
        }


        $schedule_query = Schedule::leftJoin('users', 'schedules.schedule_id', '=', 'users.id')
                                    ->select('schedule_date', 'schedule_category', 'schedule_area', 'schedule_start_time', 'schedule_end_time', 'name', 'personal', 'identifier')
                                    ->whereNotIn('schedule_id', [$schedule_id])
                                    ->whereDate('schedule_date', $date)
                                    ->where('schedule_category', $category)
                                    ->where('schedule_area', $area)
                                    ->whereTime('schedule_start_time', '>=', $time_start)
                                    ->whereTime('schedule_end_time', '<=', $time_end);

        $schedule_match = $schedule_query->get();



        if($schedule_query->count() >= 5){
            return view('match.result',['schedule_match' =>  $schedule_match, 'schedule_number' => $request->schedule_number]);

        }elseif($schedule_query->count() < 5){

            $time_range = '1hours';
            $time_start = date('H:i', strtotime($time_start."-".$time_range));
            $time_end = date('H:i', strtotime($time_end."+".$time_range));

            $schedule_query = Schedule::leftJoin('users', 'schedules.schedule_id', '=', 'users.id')
                                        ->select('schedule_date', 'schedule_category', 'schedule_area', 'schedule_start_time', 'schedule_end_time', 'name', 'personal', 'identifier')
                                        ->whereNotIn('schedule_id', [$schedule_id])
                                        ->whereDate('schedule_date', $date)
                                        ->where('schedule_category', $category)
                                        ->where('schedule_area', $area)
                                        ->whereTime('schedule_start_time', '>=', $time_start)
                                        ->whereTime('schedule_end_time', '<=', $time_end);
        }

        $schedule_match = $schedule_query->get();


        if($schedule_query->count() >= 5){
            return view('match.result',['schedule_match' =>  $schedule_match, 'schedule_number' => $request->schedule_number]);

        }elseif($schedule_query->count() < 5){

            $time_range = '1hours';
            $time_start = date('H:i', strtotime($time_start."-".$time_range));
            $time_end = date('H:i', strtotime($time_end."+".$time_range));

            $schedule_query = Schedule::leftJoin('users', 'schedules.schedule_id', '=', 'users.id')
                                        ->select('schedule_number', 'schedule_date', 'schedule_category', 'schedule_area', 'schedule_start_time', 'schedule_end_time', 'name', 'personal')
                                        ->whereNotIn('schedule_id', [$schedule_id])
                                         ->whereDate('schedule_date', $date)
                                         ->where('schedule_category', $category)
                                         ->where('schedule_area', $area)
                                         ->whereTime('schedule_start_time', '>=', $time_start)
                                         ->whereTime('schedule_end_time', '<=', $time_end);
        }

        $schedule_match = $schedule_query->get();


        if($schedule_query->exists()){
            return view('match.result',['schedule_match' =>  $schedule_match, 'schedule_number' => $request->schedule_number]);

        }elseif(! $schedule_query->exists()){
            $match_result = '相手が見つかりませんでした';
            return view('match.result',['match_result' => $match_result]);
        }

        return redirect(route('schedule'));
    }

    public function apply(Request $request){

        $partner = User::select('id', 'personal','identifier')
                        ->where('personal', $request->partner_parsonal)
                        ->get();

        $own = User::select('id', 'personal','identifier')
                     ->where('id', Auth::id())
                     ->get();

        foreach($partner as $user_partner){
            $partner_id = $user_partner->id;
            $partner_identifier = $user_partner->identifier;
            $partner_personal = $user_partner->personal;
        }

        foreach($own as $user_own){
            $own_id = $user_own->id;
            $own_identifier = $user_own->identifier;
            $own_personal = $user_own->personal;
        }


        if ($own_id < $partner_id){
            $id_small = $own_id;
            $id_large = $partner_id;
            $schedule_number = $request->schedule_number;
            $partner_number = $request->partner_number;
            $chat_identifier = $own_identifier.$partner_identifier;
        }elseif($own_id > $partner_id){
            $id_small = $partner_id;
            $id_large = $own_id;
            $schedule_number = $request->partner_number;
            $partner_number = $request->schedule_number;
            $chat_identifier = $partner_identifier.$own_identifier;
        }

        Matches::create([
            'match_id' => $id_small,
            'match_partner_id' => $id_large,
            'match_schedule_number' => $schedule_number,
            'match_partner_schedule_number' => $partner_number,
            'match_status' => null,
        ]);



        Chat::create([
            'chat_identifier' => $chat_identifier,
            'chat_personal' => $own_personal,
            'chat_partner_personal' => $partner_personal,
            'chat_text' => null
        ]);

        return redirect("/message/${chat_identifier}");

    }

    public function getSchedule(Request $request){
        $user_id = Auth::id();
        $schedule_number = $request->schedule_number;
        $user_schedule = Schedule::where('schedule_id', $user_id)
                                 ->where('schedule_number', $schedule_number)
                                 ->get();

        if($user_schedule->isEmpty()){
            return redirect()->route('home');
        }
        return $user_schedule;
    }
}


