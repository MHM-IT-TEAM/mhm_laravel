<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSinglePocketToUltrasoundThirdScreenings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ultrasound_third_screenings', function (Blueprint $table) {
            $table->string('single_pocket', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ultrasound_third_screenings', function (Blueprint $table) {
            $table->dropColumn('single_pocket');
        });
    }
}
