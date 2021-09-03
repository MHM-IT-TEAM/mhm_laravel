<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('consultations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreignId('section_id');
            $table->string('status',20)->nullable();
            $table->string('pharma_status',20)->nullable();
            $table->string('payment_status',20)->nullable();
            $table->string('temp',10)->nullable();
            $table->string('weight',10)->nullable();
            $table->integer('taSysto',)->nullable();
            $table->integer('taDia',)->nullable();
            $table->integer('pulse',)->nullable();
            $table->integer('spo2',)->nullable();
            $table->string('priority',20)->nullable();
            $table->text('remark')->nullable();
            $table->text('blue_priority_reason')->nullable();
            $table->String('responsible',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
}
