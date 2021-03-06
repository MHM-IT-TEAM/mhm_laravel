<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDue extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function patients(){
        return $this->belongsTo(Patient::class);
    }
    public function admission(){
        return $this->belongsTo(Admission::class);
    }
}
