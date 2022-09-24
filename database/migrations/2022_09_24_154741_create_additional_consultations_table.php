<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_consultations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('from_admission_id');
            $table->bigInteger('to_admission_id');
            $table->text('reason_for_consultation');
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_consultations');
    }
}
