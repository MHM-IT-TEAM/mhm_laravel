<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionCareDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_care_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id')->constrained();
            $table->foreignId('activity_price_id')->constrained();
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
