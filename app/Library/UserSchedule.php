<?php

declare(strict_types=1);

namespace App\Library;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;


trait UserSchedule
{


    public function getScheduleOrderByDate($user_id) {
        $schedule = Schedule::where('schedule_id', $user_id)
                           ->select('schedule_number', 'schedule_date', 'schedule_start_time', 'schedule_end_time', 'schedule_approval', 'schedule_game_title', 'schedule_detail')
                           ->orderBy('schedule_date');

        if($schedule->exists()) {
            $user_schedule = $schedule->get();
        }else{
            $user_schedule = false;
        }

        return $user_schedule;

    }


    public function checkDuplicateSchedule($user_id, $schedule_date, $start_time, $end_time) {
        $schedules = Schedule::select('schedule_start_time', 'schedule_end_time')
                                  ->where('schedule_id', $user_id)
                                  ->where('schedule_date', $schedule_date)
                                  ->orderBy('schedule_start_time', 'desc');

        if($schedules->exists() == false) {
            return $result = false;
        }

        foreach($schedules->get() as $schedule) {
            if($schedule->schedule_start_time < $end_time && $start_time < $schedule->schedule_end_time) {
                $result = true;
            } else {
                $result = false;
            }
        }

       return $result;
    }

    public function getSchedule(Request $request){
        $user_schedule = Schedule::leftJoin('users', 'users.id', '=', 'schedules.id')
                                    ->where('schedule_number', $request->user_number)
                                    ->get();

        if($user_schedule->isEmpty()){
            return redirect()->route('home');
        }

        $user_schedule = $user_schedule->toArray();

        return $user_schedule[0];
    }

}
