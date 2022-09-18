<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEpocToInternalLabRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_lab_requests', function (Blueprint $table) {
            //new epoc columns
            $table->smallInteger('epoc_ph')->nullable();
            $table->smallInteger('epoc_pco2')->nullable();
            $table->smallInteger('epoc_po2')->nullable();
            $table->smallInteger('epoc_chco3')->nullable();
            $table->smallInteger('epoc_be')->nullable();
            $table->smallInteger('epoc_cso2')->nullable();
            $table->smallInteger('epoc_na+')->nullable();
            $table->smallInteger('epoc_ka+')->nullable();
            $table->smallInteger('epoc_ca+')->nullable();
            $table->smallInteger('epoc_cl')->nullable();
            $table->smallInteger('epoc_hct')->nullable();
            $table->smallInteger('epoc_chgb')->nullable();
            $table->smallInteger('epoc_glu')->nullable();
            $table->smallInteger('epoc_lac')->nullable();
            $table->smallInteger('epoc_crea')->nullable();
            $table->smallInteger('epoc_urea')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_lab_requests', function (Blueprint $table) {
            //
        });
    }
}
