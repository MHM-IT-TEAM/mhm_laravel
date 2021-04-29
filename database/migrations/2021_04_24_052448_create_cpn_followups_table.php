<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpnFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('cpn_followups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('cpn_admission_id')->constrained();
            $table->string('week_of_pregnancy',10);
            $table->string('weight',10)->nullable();
            $table->string('bp_left',10)->nullable();
            $table->string('bp_right',10)->nullable();
            $table->string('eyes',10)->nullable();
            $table->string('breast',10)->nullable();
            $table->string('belly_size',10)->nullable();
            $table->string('uterus_size',10)->nullable();
            $table->string('lp1',20)->nullable();
            $table->string('lp2',20)->nullable();
            $table->string('lp3',20)->nullable();
            $table->string('mov_baby',10)->nullable();
            $table->string('heartbeat_baby',20)->nullable();
            $table->string('cervix_length',20)->nullable();
            $table->string('cervix_opening',20)->nullable();
            $table->string('cervix_position',20)->nullable();
            $table->string('liquids',20)->nullable();
            $table->string('oedema',20)->nullable();
            $table->string('varicosis',20)->nullable();
            $table->string('protein_test',10)->nullable();
            $table->string('sugar_test',10)->nullable();
            $table->string('blood_test',10)->nullable();
            $table->string('leucocyte_test',10)->nullable();
            $table->string('ogtt',10)->nullable();
            $table->string('membranes',20)->nullable();
            $table->string('leading_part',20)->nullable();
            $table->string('leading_part_attitude',20)->nullable();
            $table->boolean('us_needed')->nullable();
            $table->boolean('ctg_needed')->nullable();
            $table->string('appointment',20)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpn_followups');
    }
}
