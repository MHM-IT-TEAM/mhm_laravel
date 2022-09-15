<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBabyCheckupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baby_checkups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id')->constrained();
            $table->string('gl_impression',20)->nullable();
            $table->string('umbilic',20)->nullable();
            $table->string('skin',20)->nullable();
            $table->string('temp',200)->nullable();
            $table->integer('weight');
            $table->string('temp')->nullable();
            $table->text('precautions')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baby_checkups');
    }
}
