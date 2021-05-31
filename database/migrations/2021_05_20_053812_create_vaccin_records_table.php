<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('vaccin_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('patient_id');
            $table->bigInteger('mom_id')->nullable();
            $table->smallInteger('bcg')->nullable();
            $table->smallInteger('polio0')->nullable();
            $table->smallInteger('dtc1')->nullable();
            $table->smallInteger('polio1')->nullable();
            $table->smallInteger('dtc2')->nullable();
            $table->smallInteger('polio2')->nullable();
            $table->smallInteger('dtc3')->nullable();
            $table->smallInteger('polio3')->nullable();
            $table->smallInteger('var1')->nullable();
            $table->smallInteger('var2')->nullable();
            $table->smallInteger('pcv1')->nullable();
            $table->smallInteger('pcv2')->nullable();
            $table->smallInteger('pcv3')->nullable();
            $table->smallInteger('vpi')->nullable();
            $table->smallInteger('rota1')->nullable();
            $table->smallInteger('rota2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccin_records');
    }
}
