<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBloodPressureMedicationColumnsToCpnAdmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpn_admissions', function (Blueprint $table) {
            $table->boolean('planned_induction')->nullable();

            $table->boolean('takes_blood_pressure_medication')->nullable();
            $table->string('blood_pressure_medication_start_date',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpn_admissions', function (Blueprint $table) {
            $table->dropColumn('planned_induction');
            $table->dropColumn('takes_blood_pressure_medication');
            $table->dropColumn('blood_pressure_medication_start_date');
        });
    }
}
