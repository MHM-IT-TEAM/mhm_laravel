<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function service_activity(){
        return $this->belongsTo(ServiceActivity::class);
    }

    public function admissionCareDetails(){
        return $this->hasMany(AdmissionCareDetail::class);
    }
}
