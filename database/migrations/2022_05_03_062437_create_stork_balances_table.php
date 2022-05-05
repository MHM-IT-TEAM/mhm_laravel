<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorkBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stork_balances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('stork_admission_id');
            $table->string('date_start');
            $table->string('time_start')->nullable();
            $table->string('date_end')->nullable();
            $table->integer('number_of_hours')->nullable();
            $table->string('status',40);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stork_balances');
    }
}
