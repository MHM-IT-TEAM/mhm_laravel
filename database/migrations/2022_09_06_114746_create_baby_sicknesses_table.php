<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBabySicknessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baby_sicknesses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->foreignId('patient_id');
            $table->text('diagnose');
            $table->integer('weight')->nullable();
            $table->string('temp',10)->nullable();
            $table->string('spo2',10)->nullable();
            $table->string('lungs',10)->nullable();
            $table->string('pulse',10)->nullable();
            $table->string('intake',200)->nullable();
            $table->string('pipi',200)->nullable();
            $table->string('kacka',200)->nullable();
            $table->string('fontanelle',200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baby_sicknesses');
    }
}
