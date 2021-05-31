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
        Schema::connection('patSyst')->create('birth_medical_data_babies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('birth_id')->constrained();
            $table->string('gender',5);
            $table->string('weight',15);
            $table->string('head',15);
            $table->string('chest',15);
            $table->string('arm',15);
            $table->string('length',15);
            $table->string('apgar',15);
            $table->string('vitk',15);
            $table->string('spo2',15);
            $table->string('malformation',200)->nullable();
            $table->string('infection',200)->nullable();
            $table->string('ga_comparing',10);
            $table->boolean('extra_supervision_needed');
            $table->boolean('cpa_needed');
            $table->boolean('swobs_taken');


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
