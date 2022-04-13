<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code',3);
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('hospital_service_id');
            $table->string('admission_time',10);
            $table->foreignId('hospital_service_division_id');
            $table->string('type_of_stay',10);
            $table->string('estimated_length_of_stay',10)->nullable();
            $table->string('admission_diagnosis',200);
            $table->string('medical_antecedents',200)->nullable();
            $table->string('other_medical_issues',100)->nullable();
            $table->boolean('anesthesia_required');
            $table->string('anesthesia_type',50)->nullable();
            $table->boolean('refered_patient');
            $table->string('facility_name',30)->nullable();
            $table->string('staying_duration',10)->nullable();
            $table->string('reason_of_hospitalisation',100)->nullable();
            $table->string('reason_of_transfert',100)->nullable();
            $table->boolean('meal')->nullable();
            $table->string('meal_frequency',20)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospital_admissions');
    }
}
