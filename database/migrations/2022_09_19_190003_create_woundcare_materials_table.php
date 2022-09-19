<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWoundcareMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woundcare_materials', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('woundcare_id');
            $table->string('material');
            $table->string('quantity');
            $table->string('unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('woundcare_materials');
    }
}
