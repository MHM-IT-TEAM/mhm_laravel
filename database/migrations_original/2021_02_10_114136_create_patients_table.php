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
            $table->string('firstName',50);
            $table->string('lastName',50)->nullable();
            $table->string('birthDate',40);
            $table->string('birthPlace',40)->nullable();
            $table->string('cin_no',20)->nullable();
            $table->string('cin_date',10)->nullable();
            $table->string('cin_place',50)->nullable();
            $table->string('job',20)->nullable();
            $table->string('mom_name',50)->nullable();
            $table->string('dad_name',50)->nullable();
            $table->string('tel',20)->nullable();
            $table->string('gender',2)->nullable();
            $table->string('adress',50);
            $table->string('avatar',200)->nullable();
            $table->integer('height')->nullable();
            $table->String('martialStatus',15)->nullable();
            $table->string('nationality',20)->nullable();
            $table->string('bloodGroup',20)->nullable();
            $table->string('education',20)->nullable();
            $table->string('email',20)->nullable();
            $table->string('datereg',20)->nullable();
            $table->string('pat_photos',20)->nullable();
            $table->string('von_birth',20)->nullable();
            $table->string('reg_date',20)->nullable();

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
