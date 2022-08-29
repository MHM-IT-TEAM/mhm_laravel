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
            $table->smallInteger('stork')->nullable();
            $table->smallInteger('glDoctor')->nullable();
            $table->smallInteger('midMob')->nullable();
            $table->smallInteger('dentMob')->nullable();
            $table->smallInteger('ambulance')->nullable();
            $table->smallInteger('yuck_room')->nullable();
            $table->smallInteger('graceCenter')->nullable();
            $table->smallInteger('joyCenter')->nullable();
            $table->smallInteger('laboratory')->nullable();
            $table->smallInteger('dentDoctor')->nullable();
            $table->smallInteger('midPink')->nullable();
            $table->smallInteger('ultrasound')->nullable();
            $table->smallInteger('pf')->nullable();
            $table->smallInteger('pediatric_out_patient')->nullable();
            $table->smallInteger('pediatric_in_patient')->nullable();
            $table->smallInteger('delivery')->nullable();
            $table->smallInteger('bloc')->nullable();
            $table->smallInteger('sterilisation')->nullable();
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
