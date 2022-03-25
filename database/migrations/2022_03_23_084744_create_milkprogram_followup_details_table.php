<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkprogramFollowupDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milkprogram_followup_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('milkprogram_followup_id');
            $table->foreignId('item_id');
            $table->integer('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milkprogram_followup_details');
    }
}
