<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCareDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $connection='patSyst';
    public function consultation(){
        return $this->belongsTo(Consultation::class);
    }
}
