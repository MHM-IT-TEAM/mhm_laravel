<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVitalSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('temp',10)->nullable();
            $table->string('weight',10)->nullable();
            $table->integer('TaSysto')->nullable();
            $table->integer('taDia')->nullable();
            $table->integer('pulse')->nullable();
            $table->integer('O2')->nullable();
            $table->foreignId('patient_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vital_signs');
    }
}
