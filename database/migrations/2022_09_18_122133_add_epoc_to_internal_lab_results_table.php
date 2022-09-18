<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEpocToInternalLabResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_lab_results', function (Blueprint $table) {
            $table->string('epoc_ph')->nullable();
            $table->string('epoc_pco2')->nullable();
            $table->string('epoc_po2')->nullable();
            $table->string('epoc_chco3')->nullable();
            $table->string('epoc_be')->nullable();
            $table->string('epoc_cso2')->nullable();
            $table->string('epoc_na+')->nullable();
            $table->string('epoc_ka+')->nullable();
            $table->string('epoc_ca+')->nullable();
            $table->string('epoc_cl')->nullable();
            $table->string('epoc_hct')->nullable();
            $table->string('epoc_chgb')->nullable();
            $table->string('epoc_glu')->nullable();
            $table->string('epoc_lac')->nullable();
            $table->string('epoc_crea')->nullable();
            $table->string('epoc_urea')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_lab_results', function (Blueprint $table) {
            //
        });
    }
}
