<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthMedicalDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('birth_medical_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('birth_weight');
            $table->integer('length');
            $table->integer('arm');
            $table->integer('head');
            $table->foreignId('birth_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birth_medical_data');
    }
}
