<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUltrasoundConfirmationOfDueDateScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ultrasound_confirmation_of_due_date_screenings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('ultrasound_admission_id');
            $table->foreign('ultrasound_admission_id', 'ultrasound_cdd_ultrasound_admission_foreign')->references('id')->on('ultrasound_admissions')->constrained();
            $table->integer('fetus');
            $table->string('midwives',70)->nullable();
            $table->string('edd_method',10)->nullable();
            $table->date('edd_ultrasound')->nullable();
            $table->date('edd_corrected')->nullable();
            $table->string('gestational_age', 10);
            $table->string('hc',10)->nullable();
            $table->string('ac',10)->nullable();
            $table->string('fl',10)->nullable();
            $table->string('gs',10)->nullable();
            $table->string('crl',10)->nullable();
            $table->string('fhr',10)->nullable();
            $table->string('bpd',10)->nullable();
            $table->string('ewb',10)->nullable();
            $table->text('remark')->nullable();
            $table->text('other')->nullable();
            $table->string('responsible', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ultrasound_confirmation_of_due_date_screenings');
    }
}
