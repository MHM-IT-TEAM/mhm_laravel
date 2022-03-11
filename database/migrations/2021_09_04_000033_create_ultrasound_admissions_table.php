<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUltrasoundAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ultrasound_admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('admission_id')->constrained();
            $table->boolean('multiple_pregnancy')->nullable();
            $table->boolean('is_patient_pregnant')->nullable();
            $table->text('remark')->nullable();
            $table->boolean('unknown_lpd')->nullable();
            $table->string('last_period_date',50)->nullable();
            $table->string('edd_method',10)->nullable();
            $table->string('edd_calculated',50)->nullable();
            $table->string('edd_ultrasound',50)->nullable();
            $table->string('edd_corrected',50)->nullable();
            $table->string('calculated_ga',50)->nullable();
            $table->string('ultrasound_ga',50)->nullable();
            $table->string('corrected_ga',50)->nullable();
            $table->string('gestational_age_ultrasound', 10)->nullable();
            $table->string('gestational_age_calculated', 10)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('medical_staff', 100)->nullable();
            $table->string('status', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ultrasound_admissions');
    }
}
