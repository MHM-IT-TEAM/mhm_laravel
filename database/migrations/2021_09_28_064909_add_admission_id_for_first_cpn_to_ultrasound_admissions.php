<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdmissionIdForFirstCpnToUltrasoundAdmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ultrasound_admissions', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_id_for_first_cpn')->nullable();
            $table->foreign('admission_id_for_first_cpn', 'admission_cpn_foreign')->references('id')->on('admissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ultrasound_admissions', function (Blueprint $table) {
            $table->dropColumn('admission_id_for_first_cpn');
        });
    }
}
