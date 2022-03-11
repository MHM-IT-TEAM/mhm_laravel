<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUltrasoundThirdScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ultrasound_third_screenings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('ultrasound_admission_id')->constrained();
            $table->string('normal_growth',10)->nullable();
            $table->string('placenta_type',20)->nullable();
            $table->string('normal_birth',10)->nullable();
            $table->string('amniotic_liquid',10)->nullable();
            $table->string('wop_equality',10)->nullable();
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
            $table->date('edd_ultrasound');
            $table->string('gestational_age', 10);
            $table->integer('fetus');
            $table->string('responsible', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ultrasound_third_screenings');
    }
}
