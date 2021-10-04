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
            $table->text('body_check')->nullable();
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
            $table->string('vital_sign_update_cause')->nullable();
            $table->smallInteger('wound_care')->nullable();
            $table->smallInteger('stitches')->nullable();
            $table->smallInteger('nebulizer')->nullable();
            $table->smallInteger('vaccination')->nullable();
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
