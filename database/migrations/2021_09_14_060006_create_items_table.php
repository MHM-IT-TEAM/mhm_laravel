<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('barcode',100)->nullable();
            $table->string('code',20)->nullable();
            $table->string('description',150);
            $table->foreignId('item_type_id')->nullable();
            $table->foreignId('item_unit_id')->nullable();
            $table->foreignId('location_id')->nullable();
            $table->foreignId('administration_id')->nullable();
            $table->string('perUnit',20)->nullable();
            $table->string('price',30)->nullable();
            $table->string('status',30)->nullable();
            $table->text('purpose_of_use')->nullable();
            $table->string('dci',100)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
