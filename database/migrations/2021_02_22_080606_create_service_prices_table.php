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
        Schema::connection('patSyst')->create('service_prices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name',30);
            $table->string('price',20);
            $table->unsignedBigInteger('type_consult_id');
            $table->foreign('type_consult_id')->references('id')->on('type_consults');
            $table->boolean('sector')->default(0);
            $table->boolean('active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_prices');
    }
}
