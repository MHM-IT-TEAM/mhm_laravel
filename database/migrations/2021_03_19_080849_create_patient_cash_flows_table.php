<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientCashFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_cash_flows', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('patient_id');
            $table->integer('admission_id')->nullable();
            $table->string('code')->nullable();
            $table->string('nature')->nullable();
            $table->string('last_due',20)->nullable();
            $table->string('to_pay',20)->nullable();
            $table->string('paid',20)->nullable();
            $table->string('new_debt',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_cash_flows');
    }
}
