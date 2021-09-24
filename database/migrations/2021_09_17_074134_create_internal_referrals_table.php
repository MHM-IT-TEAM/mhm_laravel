<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_referrals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('from_admission_id');
            $table->bigInteger('to_admission_id');
            $table->foreignId('patient_id');
            $table->foreignId('category_id');
            $table->foreignId('service_id');
            $table->foreignId('service_activity_id');
            $table->text('reason_for_transfer');
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_referrals');
    }
}
