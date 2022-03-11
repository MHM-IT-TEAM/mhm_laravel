<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UltrasoundEarlyScreening extends Model
{
    use HasFactory;

    public function UltrasoundAdmission(){
        return $this->belongsTo(UltrasoundAdmission::class);
    }
}
