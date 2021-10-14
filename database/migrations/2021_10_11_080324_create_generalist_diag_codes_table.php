<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralistDiagCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generalist_diag_codes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('generalist_id');
            $table->foreignId('diag_code_id');
            $table->string('status',50);
            $table->text('details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generalist_diag_codes');
    }
}
