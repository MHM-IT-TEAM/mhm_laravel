<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];
    public function patientCareDetails(){
        return $this->hasMany(PatientCareDetail::class);
    }
    public function scopeTodayConsultation($query){
        return $query->whereDate('created_at',Carbon::today());
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function typeConsult(){
        return $this->belongsTo(TypeConsult::class);
    }

}
