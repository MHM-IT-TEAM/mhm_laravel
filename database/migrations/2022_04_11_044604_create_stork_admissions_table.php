<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorkAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stork_admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('new_request')->nullable();
            $table->boolean('changes_made')->nullable();
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('admission_id')->constrained();
            $table->string('admission_date',50);
            $table->string('admission_time',20);
            $table->foreignId('service_id');
            $table->foreignId('bed_id');
            $table->string('level_of_care',50);
            $table->string('category',50);
            $table->text('admission_diagnosis')->nullable();
            $table->string('type_of_stay')->nullable();
            $table->boolean('infection_control_referred_patient')->nullable();
            $table->string('infection_control_facility_place')->nullable();
            $table->integer('infection_control_facility_val')->nullable();
            $table->string('infection_control_facility_type')->nullable();
            $table->string('infection_control_reason_of_hospitalisation')->nullable();
            $table->string('infection_control_reason_of_transfer')->nullable();
            $table->integer("estimated_stay_length")->nullable();
            $table->integer("estimated_stay_length_type")->nullable();
            $table->string('temp')->nullable();
            $table->integer('pulse')->nullable();
            $table->string('weight')->nullable();
            $table->string('bp',40)->nullable();
            $table->string('spo2')->nullable();
            $table->boolean("anesthesia_required")->nullable();
            $table->string("anesthesia_type",40)->nullable();
            $table->string("mobilisation_status",40)->nullable();
            $table->string("type",40)->nullable();
            $table->string("mom",40)->nullable();
            $table->boolean("meal")->nullable();
            $table->integer("unpaid_amount")->nullable();
            $table->boolean("dismissed")->nullable();
            $table->string("user_id")->nullable();

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
