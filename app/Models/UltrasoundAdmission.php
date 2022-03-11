<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UltrasoundAdmission extends Model
{
    use HasFactory;

    protected $guarded=[];

//    public function ultrasound_early_screenings(){
//        return $this->hasMany(UltrasoundEarlyScreening::class);
//    }
//    public function ultrasound_first_screenings(){
//        return $this->hasMany(UltrasoundFirstScreening::class);
//    }
//    public function ultrasound_confirmation_of_due_date_screenings(){
//        return $this->hasMany(UltrasoundConfirmationOfDueDateScreening::class);
//    }
//    public function ultrasound_second_screenings(){
//        return $this->hasMany(UltrasoundSecondScreening::class);
//    }
//    public function ultrasound_third_screenings(){
//        return $this->hasMany(UltrasoundThirdScreening::class);
//    }
//    public function ultrasound_additional_screenings() {
//        return $this->hasMany(UltrasoundAdditionalScreening::class);
//    }
    public function admission()
    {
        return $this->belongsTo(Admission::class);

    }
    public function fetuses(){
        return $this->hasMany(Fetus::class);
    }
    public function ultrasoundDetails(){
        return $this->hasMany(UltrasoundDetail::class);
    }


}
