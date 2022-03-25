<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('births', function (Blueprint $table) {
            $table->id();
            $table->string('code',20);
            $table->date('birth_date');
            $table->time('birth_time');
            $table->timestamps();
            $table->string('GA',10)->nullable();
            $table->string('external_delivery',10)->nullable();
            $table->foreignId('patient_id');
            $table->bigInteger('cpn_admission_id')->nullable();
            $table->string('midwives',200)->nullable();
            $table->string('surgeons',200)->nullable();
            $table->string('anesthetists',200)->nullable();
            $table->string('nurses',200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('births');
    }
}
