<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDue extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];
    public function patients(){
        return $this->belongsTo(Patient::class);
    }
}
