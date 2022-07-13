<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    use HasFactory;
    protected $guarded= [];
    public function admission(){
        return $this->belongsTo(Admission::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function surgery_used_medicines(){
        return $this->hasMany(SurgeryUsedMedicine::class);
    }
}
