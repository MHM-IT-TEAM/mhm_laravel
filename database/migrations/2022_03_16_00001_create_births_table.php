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
            $table->boolean('induction')->nullable();
            $table->string('induction_method',250)->nullable();
            $table->text('induction_reason')->nullable();
            $table->string('responsible_midwives',200)->nullable();
            $table->string('senior_midwives',200)->nullable();
            $table->string('assistant_midwives',200)->nullable();
            $table->string('anesthetists',200)->nullable();
            $table->string('doctors',200)->nullable();
            $table->string('trainee',200)->nullable();
            $table->integer("user_id")->nullable();
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
