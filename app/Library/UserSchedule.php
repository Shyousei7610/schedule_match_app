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


        return $user_schedule;

    }

}
