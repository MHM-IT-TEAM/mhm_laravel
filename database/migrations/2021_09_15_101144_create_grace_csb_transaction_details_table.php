<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraceCsbTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grace_csb_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('item_id');
            $table->foreignId('grace_csb_transaction_id');
            $table->string('breakfast',50)->nullable();
            $table->string('lunch',50)->nullable();
            $table->string('dinner',50)->nullable();
            $table->string('to_give',50)->nullable();
            $table->string('given')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grace_csb_transaction_details');
    }
}
