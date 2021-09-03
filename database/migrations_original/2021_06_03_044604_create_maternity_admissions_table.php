<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaternityAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('maternity_admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code',20);
            $table->foreignId('patient_id')->constrained();
            $table->string('date',20);
            $table->string('time',20);
            $table->foreignId('hospital_service_division_id')->constrained();
            $table->foreignId('bed_id')->constrained();
            $table->boolean('emergency_case')->nullable();
            $table->string('vaginal_bleeding',20)->nullable();
            $table->string('severe_abdominal_pain',20)->nullable();
            $table->string('high_fever',20)->nullable();
            $table->string('severe_headache',20)->nullable();
            $table->string('breathing_difficulty',20)->nullable();
            $table->string('convulsions',20)->nullable();
            $table->string('other_danger',100)->nullable();
            $table->string('ga',10)->nullable();
            $table->string('due_date_labor',10)->nullable();
            $table->string('due_date_method',10)->nullable();
            $table->integer('cpn_ref')->nullable();
            $table->string('booked_delivery',10)->nullable();
            $table->string('planned_oc',10)->nullable();
            $table->string('labor_pain',10)->nullable();
            $table->string('pregnancy_complication',10)->nullable();
            $table->text('complication_explanation')->nullable();
            $table->text('provisional_diagnosis')->nullable();
            $table->text('final_diagnosis')->nullable();
            $table->string('bp_left',10)->nullable();
            $table->string('bp_right',10)->nullable();
            $table->integer('pulse')->nullable();
            $table->string('temp')->nullable();
            $table->string('spo2')->nullable();
            $table->string('weight')->nullable();
            $table->integer('status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maternity_admissions');
    }
}
