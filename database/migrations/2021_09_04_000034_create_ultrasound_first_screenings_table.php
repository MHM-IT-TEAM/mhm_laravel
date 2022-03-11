<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUltrasoundFirstScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ultrasound_first_screenings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('ultrasound_admission_id')->constrained();
            $table->string('intrauterine',10)->nullable();
            $table->string('heartbeat',10)->nullable();
            $table->string('embryo_visible',10)->nullable();
            $table->text('remark')->nullable();
            $table->text('other')->nullable();
            $table->string('midwives',70)->nullable();
            $table->string('hc',10)->nullable();
            $table->string('ac',10)->nullable();
            $table->string('fl',10)->nullable();
            $table->string('gs',10)->nullable();
            $table->string('crl',10)->nullable();
            $table->string('fhr',10)->nullable();
            $table->string('bpd',10)->nullable();
            $table->string('ewb',10)->nullable();
            $table->boolean('unknown_lpd')->nullable();
            $table->date('ddr')->nullable();
            $table->string('edd_method',10)->nullable();
            $table->date('edd_calculated')->nullable();
            $table->date('edd_ultrasound')->nullable();
            $table->date('edd_corrected')->nullable();
            $table->string('gestational_age', 10);
            $table->integer('fetus');
            $table->string('responsible', 50)->nullable();
            $table->string('medical_staff', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ultrasound_first_screenings');
    }
}
