<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurgeryUsedMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surgery_used_medicines', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('surgery_id');
            $table->string('medicine');
            $table->string('dosage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surgery_used_medicines');
    }
}
