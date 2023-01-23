<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStopAndStopdateToStorkPlanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stork_plan_details', function (Blueprint $table) {
            $table->boolean("stop")->default(false);
            $table->string("stopdate");
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stork_plan_details', function (Blueprint $table) {
            //
        });
    }
}
