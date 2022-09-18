<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostpartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postparts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->foreignId('patient_id');
            $table->text('diagnose');
            $table->string('eyes',50)->nullable();
            $table->string('legs',50)->nullable();
            $table->string('bp',50)->nullable();
            $table->string('perineum',50)->nullable();
            $table->text('woundcare')->nullable();
            $table->string('breast',50)->nullable();
            $table->string('belly_size',50)->nullable();
            $table->string('uterus_size',50)->nullable();
            $table->string('bleeding',50)->nullable();
            $table->string('urine',50)->nullable();
            $table->string('kacka',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postparts');
    }
}
