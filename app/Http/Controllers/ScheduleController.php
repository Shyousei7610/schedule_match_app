<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Matches;
use App\Library\UserSchedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    use UserSchedule;


    public function indexHome(){
        $schedules = $this->getScheduleOrderByDate(Auth::id());
        return view('home', ['schedules' => $schedules]);
    }

    public function indexScheduleList(){
        $schedules = $this->getScheduleOrderByDate(Auth::id());
        return view('schedule.index', ['schedules' => $schedules]);
    }

    public function indexScheduleRegister() {
        return view('schedule.register');
    }


    public function register(Request $request){
        $request->validate([
            'schedule_date' => 'required|date',
            'schedule_start_time' => 'required|date_format:H:i',
            'schedule_end_time' => 'required|date_format:H:i|after:schedule_start_time',
            'schedule_approval' => 'required|string',
            'schedule_game_title' => 'required|string|max:100',
            'schedule_detail'=> 'required|string|max:300'
        ]);

        $schedule_id = Auth::id();

        $check_duplicate_schedule = $this->checkDuplicateSchedule($schedule_id, $request->schedule_date, $request->schedule_start_time, $request->schedule_end_time);

        if($check_duplicate_schedule) {
            return redirect(route('schedule.list'));
        }

        Schedule::create([
            'schedule_id' => $schedule_id,
            'schedule_date' => $request->schedule_date,
            'schedule_start_time' => $request->schedule_start_time,
            'schedule_end_time' => $request->schedule_end_time,
            'schedule_approval' => $request->schedule_approval,
            'schedule_game_title' => $request->schedule_game_title,
            'schedule_detail'=> $request->schedule_detail,
          ]);

        return redirect(route('schedule.list'));
    }


    public function delete(Request $request){
        Schedule::where('schedule_number', $request->user_number)
                ->delete();

        return redirect(route('schedule.list'));
    }


}
