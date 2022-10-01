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
            $table->foreignId('fetus_id')->nullable();
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
            $table->string('placenta_type',100)->nullable();
            $table->string('amniotic_fluid',100)->nullable();
            $table->string('position_of_baby',100)->nullable();
            $table->string('presentation_of_baby',100)->nullable();
            $table->string('suspicion_for_malformation',100)->nullable();
            $table->text('malformation_explanation')->nullable();
            $table->string('calculated_ga')->nullable();
            $table->string('ultrasound_ga')->nullable();
            $table->string('corrected_ga')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('medical_staff', 250)->nullable();
            $table->string('ultrasound_type', 20)->nullable();
            $table->text('extra_checkup_reason')->nullable();
            $table->foreignId('ultrasound_admission_id')->nullable();
            $table->string('heartbeat',30)->nullable();
            $table->string('normal_birth',30)->nullable();
            $table->string('wop_equality',30)->nullable();
            $table->string('fetus',30)->nullable();
            $table->string('unknown_lpd',30)->nullable();
            $table->string('ddr',30)->nullable();
            $table->string('edd_method',30)->nullable();
            $table->string('edd_calculated',30)->nullable();
            $table->string('edd_ultrasound',30)->nullable();
            $table->string('edd_corrected',30)->nullable();
            $table->string('gestational_age',30)->nullable();
            $table->string('responsible',200)->nullable();
            $table->string('wop_calculated',20)->nullable();
            $table->string('wop_ultrasound',20)->nullable();
            $table->string('wop_corrected',20)->nullable();
            $table->string('medical_staff',200)->nullable();
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
