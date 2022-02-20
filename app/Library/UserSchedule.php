<?php

declare(strict_types=1);

namespace App\Library;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;


class UserSchedule
{


    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function toMatchSchedule(){

    }

    public function getSchedule(){
        $user_schedule = Schedule::where('schedule_id', $this->user_id)
                               ->orderBy('schedule_date')
                               ->get();


        return $this->convertArray($user_schedule);

    }

    public function convertArray($user_schedule){
        if($user_schedule->isEmpty()){
            return ;
        }

        $schedule_arrays = $user_schedule->toArray();

        foreach($schedule_arrays as $arrays_key => $schedule_array){
            foreach($schedule_array as $array_key => $user_schedule){

                $schedule_content[$array_key] = $user_schedule;
            }
            unset($schedule_content['schedule_id']);

            $schedules[] = $schedule_content;
        }
        return $schedules;
    }
}
