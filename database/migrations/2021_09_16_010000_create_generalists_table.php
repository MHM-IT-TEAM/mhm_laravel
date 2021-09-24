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
        Schema::create('generalists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('new_case');
            $table->foreignId('admission_id')->constrained();
            $table->text('symptoms')->nullable();
            $table->text('finding')->nullable();
            $table->integer('taDia')->nullable();
            $table->integer('taSysto')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('temp')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('spo2')->nullable();
            $table->boolean('medical_care_needed');
            $table->text('details')->nullable();
            $table->string('appointment')->nullable();
            $table->boolean('vital_sign_update_required')->nullable();
            $table->text('body_check')->nullable();
            $table->smallInteger('diagnose_confimred')->nullable();
            $table->smallInteger('diagnose_suspicion')->nullable();
            $table->smallInteger('diagnose_exclusion')->nullable();
            $table->smallInteger('wound_care')->nullable();
            $table->smallInteger('stiches')->nullable();
            $table->smallInteger('nebulizer')->nullable();
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
