<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaternityAdmission extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function maternityAdmissionDocuments(){
        return $this->hasMany(MaternityAdmissionDocument::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function bed(){
        return $this->belongsTo(Bed::class);
    }
    public function hospitalServiceDivision(){
        return $this->belongsTo(HospitalServiceDivision::class);
    }
    public function maternityActions(){
        return $this->hasMany(MaternityAction::class);
    }
}
