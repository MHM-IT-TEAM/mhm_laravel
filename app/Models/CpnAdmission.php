<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpnAdmission extends Model
{
    use HasFactory;

    protected $guarded=[];


    public static function patient_at_risk(){
        return self::where('patient_at_risk',1)->get();
    }
    public function followups(){
        return $this->hasMany(CpnFollowup::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
