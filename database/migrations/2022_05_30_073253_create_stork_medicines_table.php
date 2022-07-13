<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorkMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stork_medicines', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('stork_admission_id');
            $table->foreignId('item_id');
            $table->string('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stork_medicines');
    }
}
