<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('due_date',40)->nullable();
            $table->string('code',60);
            $table->foreignId('department_id')->constrained();
            $table->foreignId('storage_responsible_id')->constrained();
            $table->foreignId('collector_id')->constrained();
            $table->string('status',20);
            $table->text('remark')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outs');
    }
}
