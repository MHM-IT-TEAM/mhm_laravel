<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UltrasoundSecondScreening extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];
    public function ultrasound_admission(){
        return $this->belongsTo(UltrasoundAdmission::class);
    }
}
