<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalLabRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_lab_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->foreignId('lab_work_step_id')->nullable();
            $table->integer('status')->nullable();
            $table->smallInteger('blood_covid')->nullable();
            $table->smallInteger('blood_hiv')->nullable();
            $table->smallInteger('blood_crp')->nullable();
            $table->smallInteger('blood_malaria')->nullable();
            $table->smallInteger('blood_syphilis')->nullable();
            $table->smallInteger('blood_bg')->nullable();
            $table->smallInteger('blood_bilirubin')->nullable();
            $table->smallInteger('blood_epoc')->nullable();
            $table->smallInteger('blood_glycemia')->nullable();
            $table->smallInteger('blood_hb')->nullable();
            $table->smallInteger('blood_ogtt')->nullable();
            $table->smallInteger('urine_pregnancy_test')->nullable();
            $table->smallInteger('urine_small_ph')->nullable();
            $table->smallInteger('urine_small_glucose')->nullable();
            $table->smallInteger('urine_small_protein')->nullable();
            $table->smallInteger('urine_big_leucocyte')->nullable();
            $table->smallInteger('urine_big_nitrite')->nullable();
            $table->smallInteger('urine_big_protein')->nullable();
            $table->smallInteger('urine_big_ph')->nullable();
            $table->smallInteger('urine_big_blood')->nullable();
            $table->smallInteger('urine_big_sp_gravity')->nullable();
            $table->smallInteger('urine_big_ketane')->nullable();
            $table->smallInteger('urine_big_bilirubin')->nullable();
            $table->smallInteger('urine_big_glucose')->nullable();
            $table->text('remark')->nullable();
            $table->string('user',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_lab_requests');
    }
}
