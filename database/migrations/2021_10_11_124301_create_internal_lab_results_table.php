<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalLabResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_lab_results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('internal_lab_request_id');
            $table->string('blood_covid')->nullable();
            $table->string('blood_hiv')->nullable();
            $table->string('blood_malaria')->nullable();
            $table->string('blood_syphilis')->nullable();
            $table->string('blood_bg')->nullable();
            $table->string('blood_bilirubin')->nullable();
            $table->string('blood_crp')->nullable();
            $table->string('blood_glycemia')->nullable();
            $table->string('blood_hb')->nullable();
            $table->string('blood_ptt')->nullable();
            $table->string('urine_pregnancy_test')->nullable();
            $table->string('urine_small_ph')->nullable();
            $table->string('urine_small_glucose')->nullable();
            $table->string('urine_small_protein')->nullable();
            $table->string('urine_big_leucocyte')->nullable();
            $table->string('urine_big_nitrite')->nullable();
            $table->string('urine_big_protein')->nullable();
            $table->string('urine_big_ph')->nullable();
            $table->string('urine_big_blood')->nullable();
            $table->string('urine_big_sp_gravity')->nullable();
            $table->string('urine_big_ketane')->nullable();
            $table->string('urine_big_bilirubin')->nullable();
            $table->string('urine_big_glucose')->nullable();
            $table->text('remark')->nullable();
            $table->foreignId('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_lab_results');
    }
}
