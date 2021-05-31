<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UltrasoundAdmission extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];

    public function ultrasound_first_screenings(){
        return $this->hasMany(UltrasoundFirstScreening::class);
    }
    public function ultrasound_second_screenings(){
        return $this->hasMany(UltrasoundSecondScreening::class);
    }
    public function ultrasound_third_screenings(){
        return $this->hasMany(UltrasoundThirdScreening::class);
    }






}
