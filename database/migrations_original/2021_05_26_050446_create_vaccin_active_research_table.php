<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaccinActiveResearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('vaccin_active_research', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('research_date',20)->nullable();
            $table->integer('code')->nullable();
            $table->foreignId('patient_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vaccin_active_research');
    }
}
