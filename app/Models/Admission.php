<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $appends=['time'];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function service_activity(){
        return $this->belongsTo(ServiceActivity::class);
    }

    public function admissionCareDetails(){
        return $this->hasMany(AdmissionCareDetail::class);
    }
    public function graceCsbTransaction(){
        return $this->hasOne(GraceCsbTransaction::class);
    }
    public function generalist(){
        return $this->hasOne(Generalist::class);
    }
    public function admission_type(){
        return $this->belongsTo(AdmissionType::class);
    }
    public function babySicknesses(){
        return $this->hasMany(BabySickness::class);
    }
    public function getTimeAttribute()
    {
        return $this->created_at->format('H:i:s');
    }
}
