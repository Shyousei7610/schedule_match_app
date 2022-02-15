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
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedInteger('schedule_number');
            $table->date('schedule_date');
            $table->time('schedule_start_time');
            $table->time('schedule_end_time');
            $table->string('schedule_category');
            $table->string('schedule_area');
            $table->string('schedule_detail');
            $table->timestamps();

            $table->primary(['schedule_id', 'schedule_number']);
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
