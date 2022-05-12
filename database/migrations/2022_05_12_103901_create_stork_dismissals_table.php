<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorkDismissalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stork_dismissals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('stork_admission_id');
            $table->string('dismissal_date');
            $table->string('dismissal_time');
            $table->string('dismissal_diagnosis');
            $table->string('bp_l',10)->nullable();
            $table->string('bp_r',10)->nullable();
            $table->integer('pulse')->nullable();
            $table->integer('spo2')->nullable();
            $table->string('temp')->nullable();
            $table->integer('weight',)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stork_dismissals');
    }
}
