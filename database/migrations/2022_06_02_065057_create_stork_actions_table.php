<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorkActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stork_actions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('stork_admission_id');
            $table->foreignId('stork_action_group_id');
            $table->string('time')->nullable();
            $table->string('value')->nullable();
            $table->string("user")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stork_actions');
    }
}
