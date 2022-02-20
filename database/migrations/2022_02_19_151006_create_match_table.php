<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('match_partner_id');
            $table->unsignedInteger('match_schedule_number');
            $table->unsignedInteger('match_partner_schedule_number');
            $table->boolean('match_status')->nullable();
            $table->timestamps();

            $table->primary(['match_id', 'match_partner_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match');
    }
}
