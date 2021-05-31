<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCashFlow extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $connection='patSyst';

    public function patients(){
        return $this->belongsTo(Patient::class);
    }
}