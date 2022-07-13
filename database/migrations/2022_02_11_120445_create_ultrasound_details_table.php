<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUltrasoundDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ultrasound_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('fetus_id');
            $table->string('intra_uterine',10)->nullable();
            $table->string('heart_beat',10)->nullable();
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
            $table->string('amniotic_liquid',10)->nullable();
            $table->string('ga_equality',10)->nullable();
            $table->boolean('proportional_growth')->nullable();
            $table->string('placenta_type',10)->nullable();
            $table->string('amniotic_fluid',10)->nullable();
            $table->string('position_of_baby',10)->nullable();
            $table->string('presentation_of_baby',10)->nullable();
            $table->string('suspicion_for_malformation',10)->nullable();
            $table->text('malformation_explanation')->nullable();
            $table->string('calculated_ga')->nullable();
            $table->string('ultrasound_ga')->nullable();
            $table->string('corrected_ga')->nullable();
            $table->integer('user_id');
            $table->string('medical_staff', 250)->nullable();
            $table->string('ultrasound_type', 20)->nullable();
            $table->text('extra_checkup_reason')->nullable();
            $table->foreignId('ultrasound_admission_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ultrasound_details');
    }
}
