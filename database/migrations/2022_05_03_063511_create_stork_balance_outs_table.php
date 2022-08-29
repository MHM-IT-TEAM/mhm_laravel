<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorkBalanceOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stork_balance_outs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('stork_balance_id');
            $table->string('time');
            $table->string('what');
            $table->string('value');
            $table->boolean('p')->nullable();
            $table->boolean('k')->nullable();
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
        Schema::dropIfExists('stork_balance_outs');
    }
}
