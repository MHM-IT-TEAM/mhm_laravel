<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->foreignId('consultation_type_id');
            $table->bigInteger('sector')->default(0)->nullable();
            $table->bigInteger('out_sector')->default(0)->nullable();
            $table->bigInteger('vip')->default(0)->nullable();
            $table->bigInteger('mhm_staff')->default(0)->nullable();
            $table->bigInteger('mhm_staff_family')->default(0)->nullable();
            $table->bigInteger('mhm_partners')->default(0)->nullable();
            $table->bigInteger('active')->default(0)->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('service_prices');
    }
}
