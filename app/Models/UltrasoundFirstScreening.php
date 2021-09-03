<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UltrasoundFirstScreening extends Model
{
    use HasFactory;
    protected $guarded=[];



    public function UltrasoundAdmission(){
        return $this->belongsTo(UltrasoundAdmission::class);
    }



}
