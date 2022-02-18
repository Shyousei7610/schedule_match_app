<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    public function indexResult(){
        return view('match.result',[]);
    }

    public function search(Request $request){
        $schedule = $this->getSchedule($request);

        $schedule_id = $schedule['schedule_id'];
        $date = $schedule['schedule_date'];

        $category = $schedule['schedule_category'];
        $area = $schedule['schedule_area'];
        $area_prefecture = mb_strpos($schedule['schedule_area'], '県');
        $area_city = mb_strpos($schedule['schedule_area'], '市');

        $time_start = $schedule['schedule_start_time'];
        $time_end = $schedule['schedule_end_time'];

        $schedule_query = Schedule::whereNotIn('schedule_id', [$schedule_id])
                                   ->whereDate('schedule_date', $date)
                                   ->where('schedule_category', $category)
                                   ->where('schedule_area', $area)
                                   ->whereTime('schedule_start_time', '>=', $time_start)
                                   ->whereTime('schedule_end_time', '<=', $time_end);

        $schedule_match = $schedule_query->get();



        if($schedule_query->count() >= 5){

            return view('match.result',['schedule_match' =>  $schedule_match]);

        }elseif($schedule_query->count() < 5){

            $time_range = '1hours';
            $time_start = date('H:i', strtotime($schedule['schedule_start_time']."-".$time_range));
            $time_end = date('H:i', strtotime($schedule['schedule_end_time']."+".$time_range));

            $schedule_query = Schedule::whereNotIn('schedule_id', [$schedule_id])
            ->whereDate('schedule_date', $date)
            ->where('schedule_category', $category)
            ->where('schedule_area', $area)
            ->whereTime('schedule_start_time', '>=', $time_start)
            ->whereTime('schedule_end_time', '<=', $time_end);
        }

        $schedule_match = $schedule_query->get();


        if($schedule_query->count() >= 5){

            return view('match.result',['schedule_match' =>  $schedule_match]);

        }elseif($schedule_query->count() < 5){

            $time_range = '2hours';
            $time_start = date('H:i', strtotime($schedule['schedule_start_time']."-".$time_range));
            $time_end = date('H:i', strtotime($schedule['schedule_end_time']."+".$time_range));

            $schedule_query = Schedule::whereNotIn('schedule_id', [$schedule_id])
                                ->whereDate('schedule_date', $date)
                                ->where('schedule_category', $category)
                                ->where('schedule_area', $area)
                                ->whereTime('schedule_start_time', '>=', $time_start)
                                ->whereTime('schedule_end_time', '<=', $time_end);
        }

        $schedule_match = $schedule_query->get();


        if($schedule_query->exists()){

            return view('match.result',['schedule_match' =>  $schedule_match]);

        }elseif(! $schedule_query->exists()){
            $match_result = '相手が見つかりませんでした';
            return view('match.result',['match_result' => $match_result]);
        }

        return redirect(route('schedule'));
    }

    public function apply(Request $request){
        $user_id = Auth::id();
        if(is_int($request->partner_id))
        return ;
    }

    public function getSchedule(Request $request){
        $user_id = Auth::id();
        $schedule_number = $request->number;
        $user_schedule = Schedule::where('schedule_id', $user_id)
                                 ->where('schedule_number', $schedule_number)
                                 ->get();

        if($user_schedule->isEmpty()){
            return redirect()->route('home');
        }

        $schedule_array = $user_schedule->toArray();
        $schedule_content = $schedule_array[0];

            return $schedule_content;
        }

}
