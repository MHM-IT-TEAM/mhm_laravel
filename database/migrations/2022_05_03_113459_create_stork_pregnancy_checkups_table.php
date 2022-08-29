<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorkPregnancyCheckupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stork_pregnancy_checkups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('stork_admission_id');
            $table->string('bdcf')->nullable();
            $table->string('ctg')->nullable();
            $table->integer('belly_size')->nullable();
            $table->integer('hu')->nullable();
            $table->integer('weight')->nullable();
            $table->text('remark')->nullable();
            $table->string("user")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stork_pregnancy_checkups');
    }
}
