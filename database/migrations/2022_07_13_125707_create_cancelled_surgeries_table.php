<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancelledSurgeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancelled_surgeries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->foreignId('patient_id');
            $table->text('reason_for_cancellation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cancelled_surgeries');
    }
}
