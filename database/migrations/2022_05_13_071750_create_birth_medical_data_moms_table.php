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
        Schema::create('birth_medical_data_moms', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('birth_id')->constrained();
            $table->string('injuries',50)->nullable();
            $table->string('blood_loss',10)->nullable();
            $table->string('stiches',200)->nullable();
            $table->string('anesthesia',200)->nullable();
            $table->string('placenta_time',10)->nullable();
            $table->string('placenta_complete',10)->nullable();
            $table->string('placenta_spontaneous',10)->nullable();
            $table->string('placenta_manual_delivery',10)->nullable();
            $table->string('placenta_curetage',10)->nullable();
            $table->string('supervision_needed',10)->nullable();
            $table->string('ctg',50)->nullable();
            $table->string('complication_mom_before_birth',250)->nullable();
            $table->string('complication_mom_after_birth',250)->nullable();
            $table->string('position',50)->nullable();
            $table->text('remarks')->nullable();
            $table->string('sterilisation_package',100)->nullable();
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
