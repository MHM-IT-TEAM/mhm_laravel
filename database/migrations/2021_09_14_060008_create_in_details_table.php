<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('in_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('in_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->string('quantity',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('in_details');
    }
}
