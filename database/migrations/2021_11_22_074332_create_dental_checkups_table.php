<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentalCheckupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_checkups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('admission_id');
            $table->foreignId('patient_id');
            $table->string('t11',20)->nullable();
            $table->string('t12',20)->nullable();
            $table->string('t13',20)->nullable();
            $table->string('t14',20)->nullable();
            $table->string('t15',20)->nullable();
            $table->string('t16',20)->nullable();
            $table->string('t17',20)->nullable();
            $table->string('t18',20)->nullable();
            $table->string('t21',20)->nullable();
            $table->string('t22',20)->nullable();
            $table->string('t23',20)->nullable();
            $table->string('t24',20)->nullable();
            $table->string('t25',20)->nullable();
            $table->string('t26',20)->nullable();
            $table->string('t27',20)->nullable();
            $table->string('t28',20)->nullable();
            $table->string('t31',20)->nullable();
            $table->string('t32',20)->nullable();
            $table->string('t33',20)->nullable();
            $table->string('t34',20)->nullable();
            $table->string('t35',20)->nullable();
            $table->string('t36',20)->nullable();
            $table->string('t37',20)->nullable();
            $table->string('t38',20)->nullable();
            $table->string('t41',20)->nullable();
            $table->string('t42',20)->nullable();
            $table->string('t43',20)->nullable();
            $table->string('t44',20)->nullable();
            $table->string('t45',20)->nullable();
            $table->string('t46',20)->nullable();
            $table->string('t47',20)->nullable();
            $table->string('t48',20)->nullable();
            $table->string('t51',20)->nullable();
            $table->string('t52',20)->nullable();
            $table->string('t53',20)->nullable();
            $table->string('t54',20)->nullable();
            $table->string('t55',20)->nullable();
            $table->string('t61',20)->nullable();
            $table->string('t62',20)->nullable();
            $table->string('t63',20)->nullable();
            $table->string('t64',20)->nullable();
            $table->string('t65',20)->nullable();
            $table->string('t71',20)->nullable();
            $table->string('t72',20)->nullable();
            $table->string('t73',20)->nullable();
            $table->string('t74',20)->nullable();
            $table->string('t75',20)->nullable();
            $table->string('t81',20)->nullable();
            $table->string('t82',20)->nullable();
            $table->string('t83',20)->nullable();
            $table->string('t84',20)->nullable();
            $table->string('t85',20)->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dental_checkups');
    }
}
