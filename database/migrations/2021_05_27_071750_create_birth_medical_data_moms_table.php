<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthMedicalDataMomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('birth_medical_data_moms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('birth_id')->constrained();
            $table->string('injuries',50)->nullable();
            $table->string('blood_loss',10)->nullable();
            $table->string('suture',10)->nullable();
            $table->string('placenta_time',10)->nullable();
            $table->boolean('placenta_complete');
            $table->boolean('placenta_spontaneous');
            $table->boolean('placenta_manual_delivery');
            $table->boolean('placenta_curetage');
            $table->boolean('supervision_needed');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birth_medical_data_moms');
    }
}
