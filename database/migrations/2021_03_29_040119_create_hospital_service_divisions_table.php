<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalServiceDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('hospital_service_divisions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name',25);
            $table->foreignId('hospital_service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospital_service_divisions');
    }
}
