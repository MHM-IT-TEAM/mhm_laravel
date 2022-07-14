<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_referrals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->string('departure_date')->nullable();
            $table->string('departure_time')->nullable();
            $table->string('medical_center_id');
//            $table->string('service');
            $table->string('reason');
            $table->string('category');
            $table->foreignId('car_id');
            $table->string('patient_condition')->nullable();
            $table->boolean('oxygen_needed')->nullable();
            $table->boolean('extra_supervision_needed')->nullable();
            $table->string('extra_supervision_details')->nullable();
            $table->text('events')->nullable();
            $table->string('driver')->nullable();
            $table->integer('medical_team');
            $table->text('remark')->nullable();
            $table->foreignId('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_referrals');
    }
}
