<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorkWeeklyMeasurmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stork_weekly_measurments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('stork_admission_id');
            $table->integer('head')->nullable();
            $table->integer('chest')->nullable();
            $table->integer('arm')->nullable();
            $table->integer('length')->nullable();
            $table->integer('ear_to_ear')->nullable();
            $table->string("user")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stork_weekly_measurments');
    }
}
