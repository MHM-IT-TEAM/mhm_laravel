<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaternityActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('maternity_actions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('maternity_admission_id')->constrained();
            $table->foreignId('maternity_action_list_id');
            $table->string('value',50)->nullable();
            $table->string('action_date',20);
            $table->string('action_time',20);
            $table->string('responsible',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maternity_actions');
    }
}
