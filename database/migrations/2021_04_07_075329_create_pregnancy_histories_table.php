<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePregnancyHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('pregnancy_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('patient_id')->constrained();
            $table->string('nr_year',20)->nullable();
            $table->text('pregnancy')->nullable();
            $table->string('birth_type',20)->nullable();
            $table->string('birth_place',100)->nullable();
            $table->text('birth_problems')->nullable();
            $table->string('baby_gender',10)->nullable();
            $table->string('infection',50)->nullable();
            $table->string('malformation',50)->nullable();
            $table->integer('baby_weight')->nullable();
            $table->string('baby_condition',20)->nullable();
            $table->string('sa',10)->nullable();
            $table->text('pueperium')->nullable();
            $table->boolean('ourPatient')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pregnancy_histories');
    }
}
