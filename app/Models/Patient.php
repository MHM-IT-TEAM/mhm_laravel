<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $connection= "patSyst";
    protected $guarded=[];
    public function search($search){
        return $this->with("emContacts")
            ->where('id',$search)
            ->orWhere('firstName','LIKE','%'.$search.'%')
            ->orWhere('lastName','LIKE','%'.$search.'%')
            ->orWhere('adress','LIKE','%'.$search.'%')
            ->orWhere('birthDate','LIKE','%'.$search.'%')
            ->orWhere('cin_no','LIKE','%'.$search.'%')
            ->orWhere('email','LIKE','%'.$search.'%')
            ->orWhere('cin_no','LIKE','%'.$search.'%');
    }
    public function emContacts(){
        return $this->hasMany(EmContact::class);
    }
    public function patient_due(){
            return $this->hasOne(PatientDue::class);
    }
    public function vitalSigns(){
        return $this->hasMany(VitalSign::class);
    }
    public function patientCashFlows(){
        return $this->hasMany(PatientCashFlow::class);
    }
    public function babyCheckups(){
        return $this->hasManyThrough(BabyCheckup::class,Consultation::class);
    }
    public function birth(){
        return $this->belongsTo(Birth::class);
    }
    public function birth_medical_data(){
        return $this->hasManyThrough(BirthMedicalData::class,Birth::class);
    }
}
