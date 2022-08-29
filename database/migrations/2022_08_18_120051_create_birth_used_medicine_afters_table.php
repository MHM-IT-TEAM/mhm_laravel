<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthUsedMedicineAftersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('birth_used_medicine_afters', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId("birth_id");
            $table->string("medicine");
            $table->string("time");
            $table->string("quantity");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birth_used_medicine_afters');
    }
}
