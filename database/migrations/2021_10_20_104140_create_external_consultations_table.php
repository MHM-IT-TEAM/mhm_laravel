<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_consultations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->foreignId('user_id');
            $table->foreignId('medical_center_id');
            $table->foreignId('service');
            $table->foreignId('car_id')->nullable();
            $table->boolean('transport_needed')->nullable();
            $table->integer('km_start')->nullable();
            $table->integer('km_end')->nullable();
            $table->string('reason');
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
        Schema::dropIfExists('external_consultations');
    }
}
