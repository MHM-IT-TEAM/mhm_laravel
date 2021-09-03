<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->foreignId('service_activity_id');
            $table->bigInteger('sector')->default(0)->nullable();
            $table->bigInteger('out_sector')->default(0)->nullable();
            $table->bigInteger('mhm_staff')->default(0)->nullable();
            $table->bigInteger('mhm_staff_family')->default(0)->nullable();
            $table->bigInteger('vip')->default(0)->nullable();
            $table->bigInteger('mhm_partners')->default(0)->nullable();
            $table->boolean('joyCenter')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('service_prices');
    }
}
