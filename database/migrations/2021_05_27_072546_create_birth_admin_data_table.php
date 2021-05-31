<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBirthAdminDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('patSyst')->create('birth_admin_data', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('birth_id')->constrained();
            $table->string('dad_first_name',150)->nullable();
            $table->string('dad_last_name',100)->nullable();
            $table->string('dad_dob',15)->nullable();
            $table->string('dad_pob',150)->nullable();
            $table->string('dad_address',150)->nullable();
            $table->string('dad_cin_no',30)->nullable();
            $table->string('dad_cin_date',10)->nullable();
            $table->string('dad_cin_place',30)->nullable();
            $table->string('dad_cin_job',30)->nullable();
            $table->string('declarant_first_name',150)->nullable();
            $table->string('declarant_last_name',100)->nullable();
            $table->string('declarant_dob',15)->nullable();
            $table->string('declarant_pob',150)->nullable();
            $table->string('declarant_address',150)->nullable();
            $table->string('declarant_cin_no',30)->nullable();
            $table->string('declarant_cin_date',10)->nullable();
            $table->string('declarant_cin_place',30)->nullable();
            $table->string('declarant_cin_job',30)->nullable();
            $table->boolean('parent_married');
            $table->boolean('dad_parenting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('birth_admin_data');
    }
}
