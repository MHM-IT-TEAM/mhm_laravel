<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthMedicalDataMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('birth_medical_data_mains', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('birth_id')->constrained();
            $table->foreignId('birth_type_id')->constrained();
            $table->text('complications')->nullable();
            $table->string('injuries',100)->nullable();
            $table->string('GA',10);
            $table->string('position_mom',50)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birth_medical_data_mains');
    }
}
