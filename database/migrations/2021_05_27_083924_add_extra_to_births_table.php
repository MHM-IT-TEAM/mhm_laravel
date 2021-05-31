<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraToBirthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->table('births', function (Blueprint $table) {
            $table->foreignId('cpn_admission_id')->constrained();
            $table->foreignId('ultrasound_admission_id')->constrained();
            $table->string('senior_midwives',200)->nullable();
            $table->string('assistant_midwives',200)->nullable();
            $table->string('doctors',100)->nullable();
            $table->string('Anesthesists',100)->nullable();
            $table->string('surgeons',100)->nullable();
            $table->string('date_arrived',20)->nullable();
            $table->string('time_arrived',20)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('births', function (Blueprint $table) {
            //
        });
    }
}
