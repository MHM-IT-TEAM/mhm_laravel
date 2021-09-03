<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $guarded=[];


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
        return $this->hasMany(BirthMedicalDataBaby::class);
    }
    public function cpnAdmissions(){
        return $this->hasMany(CpnAdmission::class);
    }
    public function ultraSoundAdmissions(){
        return $this->hasMany(UltrasoundAdmission::class);
    }

    public function search($searchWords){
        $query = $this->with("emContacts");

        foreach ($searchWords as $word)
        {
            $query = $query->where(function ($q) use ($word) {
                $q
                    ->where('id',$word)
                    ->orWhere('firstName','LIKE','%'.$word.'%')
                    ->orWhere('lastName','LIKE','%'.$word.'%')
                    ->orWhere('birthDate','LIKE','%'.$word.'%')
                    ->orWhere('cin_no','LIKE','%'.$word.'%')
                    ->orWhere('email','LIKE','%'.$word.'%')
                    ->orWhere('tel','LIKE','%'.$word.'%');
            });
        }

        return $query;
    }
    public function filter($data){
        if(strlen($data->firstName)>4){
            $patient= $this->where('firstName','lIKE','%'.$data->firstName.'%');
            if($data->lastName !== null){
                $patient= $patient->where('lastName','LIKE','%'.$data->lastName.'%')->orWhere('firstName','LIKE','%'.$data->lastName.'%');
            }
            return $patient->get();
        }

    }
}
