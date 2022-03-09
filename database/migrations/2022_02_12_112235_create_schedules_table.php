<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('schedule_number');
            $table->unsignedBigInteger('schedule_id');
            $table->date('schedule_date');
            $table->time('schedule_start_time');
            $table->time('schedule_end_time');
            $table->string('schedule_approval');
            $table->string('schedule_game_title');
            $table->string('schedule_detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
