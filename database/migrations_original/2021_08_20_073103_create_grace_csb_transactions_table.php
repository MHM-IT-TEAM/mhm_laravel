<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGraceCsbTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('inventSyst')->create('grace_csb_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('consultation_id');
            $table->boolean('done')->nullable();
            $table->string('responsible')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grace_csb_transactions');
    }
}
