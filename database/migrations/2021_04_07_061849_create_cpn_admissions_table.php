<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpnAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('cpn_admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code',20)->unique();
            $table->foreignId('patient_id')->constrained();
            $table->string('ddr',20);
            $table->String('dpa',10);
            $table->String('dpa_method',10)->nullable();
            $table->integer('gravida')->nullable();
            $table->integer('parity')->nullable();
            $table->integer('abortion')->nullable();
            $table->integer('miscarriage')->nullable();
            $table->integer('ev')->nullable();
            $table->string('dda',20)->nullable();
            $table->text('problems_with_last_delivery')->nullable();
            $table->integer('spin')->nullable();
            $table->integer('christ')->nullable();
            $table->integer('troch')->nullable();
            $table->integer('obst')->nullable();
            $table->integer('michaelis')->nullable();
            $table->string('baum-hg',10)->nullable();
            $table->boolean('problem_for_delivery')->nullable();
            $table->string('blood_group',10)->nullable();
            $table->string('hiv',10)->nullable();
            $table->string('syphilis',10)->nullable();
            $table->string('hb',10)->nullable();
            $table->string('other_test',10)->nullable();
            $table->boolean('twins')->nullable();
            $table->boolean('oc')->nullable();
            $table->string('close_family',50)->nullable();
            $table->string('pregnant_woman',50)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cpn_admissions');
    }
}
