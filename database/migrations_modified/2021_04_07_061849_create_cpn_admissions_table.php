<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpnAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpn_admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('patient_id')->constrained();
            $table->string('ddr',50)->nullable();
            $table->boolean('unknown_lpd')->nullable();
            $table->string('wop',10)->nullable();
            $table->String('dpa',10)->nullable();
            $table->string('weight',20)->nullable();
            $table->String('dpa_method',10)->nullable();
            $table->String('dpa_corrected',50)->nullable();
            $table->String('dpa_echo',50)->nullable();
            $table->String('dpa_calc',50)->nullable();
            $table->integer('gravida')->nullable();
            $table->integer('parity')->nullable();
            $table->integer('abortion')->nullable();
            $table->integer('miscarriage')->nullable();
            $table->integer('ev')->nullable();
            $table->string('dda',20)->nullable();
            $table->boolean('patient_at_risk')->nullable();
            $table->string('risk_description',50)->nullable();
            $table->boolean('planned_oc')->nullable();
            $table->string('planned_oc_date',50)->nullable();
            $table->boolean('preeclampsia_needed')->nullable();
            $table->boolean('ogtt_needed')->nullable();
            $table->integer('spin')->nullable();
            $table->integer('christ')->nullable();
            $table->integer('troch')->nullable();
            $table->integer('obst')->nullable();
            $table->string('michaelis',20)->nullable();
            $table->string('baum_hg',10)->nullable();
            $table->boolean('problem_for_delivery')->nullable();
            $table->string('blood_group',5)->nullable();
            $table->string('rhesus',5)->nullable();
            $table->string('hiv',10)->nullable();
            $table->string('syphilis',10)->nullable();
            $table->string('hb',10)->nullable();
            $table->string('other_test',10)->nullable();
            $table->string('other_test_descr',20)->nullable();
            $table->string('close_family_twins',100)->nullable();
            $table->string('close_family_disease',100)->nullable();
            $table->string('close_family_malformation',100)->nullable();
            $table->string('close_family_prob_in_preg',100)->nullable();
            $table->boolean('close_family_dead_baby')->nullable();
            $table->boolean('close_family_miscarriage')->nullable();
            $table->string('close_family_oc',100)->nullable();
            $table->string('preg_wom_disability',100)->nullable();
            $table->boolean('preg_wom_bleeding')->nullable();
            $table->boolean('preg_wom_haematoma')->nullable();
            $table->string('preg_wom_medication',100)->nullable();
            $table->string('preg_wom_chronical_disease',50)->nullable();
            $table->string('preg_wom_allergie',50)->nullable();
            $table->string('preg_wom_former_illness',50)->nullable();
            $table->string('responsible',50)->nullable();
            $table->bigInteger('ultrasound_admission_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpn_admissions');
    }
}
