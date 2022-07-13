<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurgeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surgeries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->foreignId('patient_id');
            $table->string('date_of_surgery');
            $table->string('time_surgery')->nullable();
            $table->string('time_is_surgery_finished')->nullable();
            $table->string('start_time_no_food');
            $table->string('reason_for_surgery');
            $table->string('type_of_surgery',50);
            $table->text('comment')->nullable();
            $table->string('emla_on')->nullable();
            $table->string('emla_off')->nullable();
            $table->integer('weight')->nullable();
            $table->string('temp')->nullable();
            $table->integer('pulse')->nullable();
            $table->integer('taDia')->nullable();
            $table->integer('taSysto')->nullable();
            $table->integer('spo2')->nullable();
            $table->string('status',20)->nullable();
            $table->text('surgery_report')->nullable();
            $table->string('dismissal_outcome')->nullable();
            $table->string('wound_care')->nullable();
            $table->string('wound_care_date')->nullable();
            $table->string('next_surgery')->nullable();
            $table->string('next_surgery_date')->nullable();
            $table->string('appointment_for_followup')->nullable();
            $table->string('surgeons')->nullable();
            $table->string('doctors')->nullable();
            $table->string('anesthetists')->nullable();
            $table->string('nurses')->nullable();
            $table->string('midwives')->nullable();
            $table->string('other_people')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surgeries');
    }
}
