<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_referrals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->string('medical_center_id');
            $table->string('other_medical_center')->nullable();
            $table->string('service');
            $table->string('reason');
            $table->string('patient_condition')->nullable();
            $table->foreignId('car_id');
            $table->string('departure_mhm')->nullable();
            $table->string('departure_destination')->nullable();
            $table->string('arrival_mhm')->nullable();
            $table->string('arrival_destination')->nullable();
            $table->integer('driver');
            $table->integer('midwife')->nullable();
            $table->integer('midwife_1')->nullable();
            $table->integer('anesthetist')->nullable();
            $table->integer('nurse')->nullable();
            $table->boolean('oxigen_needed')->nullable();
            $table->boolean('extra_supervision_needed')->nullable();
            $table->string('extra_supervision_details')->nullable();
            $table->text('events')->nullable();
            $table->text('remark')->nullable();
            $table->string('patient_condition_at_discharge')->nullable();
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_referrals');
    }
}
