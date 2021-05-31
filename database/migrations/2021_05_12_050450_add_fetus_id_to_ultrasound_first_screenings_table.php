<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFetusIdToUltrasoundFirstScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->table('ultrasound_first_screenings', function (Blueprint $table) {
            $table->integer('fetus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ultrasound_first_screenings', function (Blueprint $table) {
            //
        });
    }
}
