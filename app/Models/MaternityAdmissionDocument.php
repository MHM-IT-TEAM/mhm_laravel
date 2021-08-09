<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaternityAdmissionDocument extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $connection='patSyst';
    public function maternityAdmission(){
        return $this->belongsTo(MaternityAdmission::class);
    }
}