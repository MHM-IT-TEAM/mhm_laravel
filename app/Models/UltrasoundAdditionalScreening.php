<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UltrasoundAdditionalScreening extends Model
{
    use HasFactory;
    
    public function ultrasound_admission(){
        return $this->belongsTo(UltrasoundAdmission::class);
    }
}
