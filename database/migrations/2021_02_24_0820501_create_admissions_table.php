<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('patient_id');
            $table->foreignId('category_id');
            $table->foreignId('service_id');
            $table->foreignId('service_activity_id');
            $table->foreignId('user_id');
            $table->integer('admission_priority_id')->nullable();
            $table->string('status',20)->nullable();
            $table->string('pharmacy_status',20)->nullable();
            $table->string('payment_status',20)->nullable();
            $table->String('provisional_diagnosis')->nullable();
            $table->string('temp',10)->nullable();
            $table->string('weight',10)->nullable();
            $table->integer('taSysto',)->nullable();
            $table->integer('taDia',)->nullable();
            $table->integer('pulse',)->nullable();
            $table->integer('spo2',)->nullable();
            $table->text('remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admissions');
    }
}
