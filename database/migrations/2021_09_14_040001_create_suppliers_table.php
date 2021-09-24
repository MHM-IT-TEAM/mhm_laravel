<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name',100);
            $table->string('nif',40)->nullable();
            $table->string('stat',40)->nullable();
            $table->string('contact',40)->nullable();
            $table->string('email',40)->nullable();
            $table->string('address',100)->nullable();
            $table->string('phone',40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
