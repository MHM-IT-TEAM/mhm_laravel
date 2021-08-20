<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('generalists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('new_case');
            $table->foreignId('consultation_id')->constrained();
            $table->text('complaint')->nullable();
            $table->text('finding')->nullable();
            $table->string('malaria')->nullable();
            $table->string('syphilis')->nullable();
            $table->string('hiv')->nullable();
            $table->boolean('medical_care_needed');
            $table->string('diagnose');
            $table->string('diag_code');
            $table->text('details')->nullable();
            $table->string('appointment')->nullable();
            $table->string('responsible');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generalists');
    }
}
