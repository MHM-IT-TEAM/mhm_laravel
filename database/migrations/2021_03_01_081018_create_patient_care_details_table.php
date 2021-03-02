<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientCareDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('patient_care_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('consultation_id')->constrained();
            $table->foreignId('service_prices_id')->constrained();
            $table->integer('qty');
            $table->string('total',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_care_details');
    }
}
