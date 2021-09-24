<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('min_stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('item_id')->constrained();
            $table->integer('general')->nullable();
            $table->integer('graceCenter')->nullable();
            $table->integer('storkCenter')->nullable();
            $table->integer('block')->nullable();
            $table->integer('midPink')->nullable();
            $table->integer('pediatric')->nullable();
            $table->integer('anesthetist')->nullable();
            $table->integer('ambulance')->nullable();
            $table->integer('glDoctor')->nullable();
            $table->integer('dentDoctor')->nullable();
            $table->integer('midMob')->nullable();
            $table->integer('dentMob')->nullable();
            $table->integer('glMob')->nullable();
            $table->integer('office')->nullable();
            $table->integer('houseHold')->nullable();
            $table->integer('joyCenter')->nullable();
            $table->integer('technical')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('min_stocks');
    }
}
