<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralistMedicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generalist_medications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('generalist_id')->constrained();
            $table->string('medicine',200);
            $table->string('breakfast',50)->nullable();
            $table->string('lunch',50)->nullable();
            $table->string('dinner',50)->nullable();
            $table->string('to_give',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generalist_medications');
    }
}
