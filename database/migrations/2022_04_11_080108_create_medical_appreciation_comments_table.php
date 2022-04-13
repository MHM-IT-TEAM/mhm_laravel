<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalAppreciationCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_appreciation_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('medical_appreciation_id');
            $table->text('comment')->nullable();
            $table->string('author',50);
            $table->bigInteger('user_id');
            $table->string('status',10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_appreciation_comments');
    }
}
