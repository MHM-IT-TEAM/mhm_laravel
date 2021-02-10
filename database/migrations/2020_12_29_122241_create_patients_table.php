<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('firstname',50);
            $table->string('lastname',50)->nullable();
            $table->string('birthdate',40);
            $table->string('birth_place',40);
            $table->string('cin_date',10);
            $table->string('cin_place',50);
            $table->string('job',20);
            $table->string('mom_name',50);
            $table->string('dad_name',50);
            $table->string('tel',20)->nullable();
            $table->string('gender',2)->nullable();
            $table->string('adress',50);
            $table->string('avatar',200)->nullable();
            $table->integer('height')->nullable();
            $table->string('reg_date',10)->nullable();

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
