<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function indexHome(){
        $schedules = $this->getSchedule();
        return view('home', ['schedules' => $schedules]);
    }

    public function indexSchedule(){
        $schedules = $this->getSchedule();
        return view('schedule', ['schedules' => $schedules]);
    }


    public function register(Request $request){
        $request->validate([
            'schedule_date' => 'required|date',
            'schedule_start_time' => 'required|date_format:H:i',
            'schedule_end_time' => 'required|date_format:H:i|after:schedule_start_time',
            'schedule_category' => 'required|string|max:20',
            'schedule_prefectures' => 'required|string',
            'schedule_cities' => 'required|string',
            'schedule_towns' => 'required|string',
            'schedule_detail'=> 'required|string|max:300'
        ]);

        $schedule_id = Auth::id();
        $user_schedule = Schedule::where('schedule_id', $schedule_id)
                               ->orderBy('schedule_number', 'desc')
                               ->limit(1)
                               ->get();


        if($user_schedule == null){
            $schedule_number = 0;
        }else{
            $schedule_array = $user_schedule->toArray();
            $schedule_number = current(array_column($schedule_array, 'schedule_number'));
            $schedule_number++;
        };

        $schedule_area = $request->schedule_prefectures.$request->schedule_cities.$request->schedule_towns;

        Schedule::create([
            'schedule_id' => $schedule_id,
            'schedule_number' => $schedule_number,
            'schedule_date' => $request->schedule_date,
            'schedule_start_time' => $request->schedule_start_time,
            'schedule_end_time' => $request->schedule_end_time,
            'schedule_category' => $request->schedule_category,
            'schedule_area' => $schedule_area,
            'schedule_detail'=> $request->schedule_detail,
        ]);

        return redirect('/home');
    }

    public function delete(){
        return redirect()->route('home');
    }

    public function deleted(Request $request){
        $user_id = Auth::id();
        Schedule::where('schedule_id', $user_id)
                ->where('schedule_number', $request->number)
                ->delete();

        return redirect('/schedule');
    }


    public function getSchedule(){
        $user_id = Auth::id();
        $user_schedule = Schedule::where('schedule_id', $user_id)
                               ->orderBy('schedule_date')
                               ->get();

        if($user_schedule->isEmpty()){
            return ;
        }

        $schedule_arrays = $user_schedule->toArray();

        foreach($schedule_arrays as $arrays_key => $schedule_array){
            foreach($schedule_array as $array_key => $user_schedule){

                $schedule_content[$array_key] = $user_schedule;
                unset($schedule_content['schedule_id']);
            }

            $schedules[] = $schedule_content;
        }
        return $schedules;
    }


}
