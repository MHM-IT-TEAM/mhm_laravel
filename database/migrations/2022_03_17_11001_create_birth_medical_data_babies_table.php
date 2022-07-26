<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthMedicalDataBabiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('birth_medical_data_babies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('birth_id')->constrained();
            $table->bigInteger('patient_id');
            $table->string('gender',5)->nullable();
            $table->string('weight',15)->nullable();
            $table->string('modus',40)->nullable();
            $table->string('head',15)->nullable();
            $table->string('chest',15)->nullable();
            $table->string('arm',15)->nullable();
            $table->string('length',15)->nullable();
            $table->string('apgar',15)->nullable();
            $table->string('vit_k',15)->nullable();
            $table->string('E1',15)->nullable();
            $table->string('spo2',15)->nullable();
            $table->string('malformation',200)->nullable();
            $table->string('position',200)->nullable();
            $table->string('infection',200)->nullable();
            $table->string('correlation',10)->nullable();
            $table->string('extra_supervision_needed',10)->nullable();
            $table->string('cpa_needed',10)->nullable();
            $table->string('swobs_taken',10)->nullable();
            $table->string('baby_not_crying',10)->nullable();
            $table->string('risk_of_cerebral_palsy',10)->nullable();
            $table->string('alive',10)->nullable();
            $table->text('death_explanation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birth_medical_data_babies');
    }
}
