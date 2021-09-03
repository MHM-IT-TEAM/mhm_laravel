<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalAppreciationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('medical_appreciations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('maternity_admission_id');
            $table->string('title','100');
            $table->text('description')->nullable();
            $table->integer('user_id');
            $table->string('status',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_appreciations');
    }
}
