<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Birth extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    public function birth_medical_datas(){
        return $this->hasMany(BirthMedicalData::class);
    }
    public function patients(){
        return $this->hasMany(Patient::class);
    }
}
