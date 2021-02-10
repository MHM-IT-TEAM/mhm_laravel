<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvatarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("patSyst")->create('avatars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->String("path");
            $table->unsignedBigInteger("patient_id");
            $table->foreign("patient_id")->references("id")->on("patients");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avatars');
    }
}
