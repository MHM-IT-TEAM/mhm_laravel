<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthMedicalDataBaby extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function birth(){
        return $this->belongsTo(Birth::class);
    }

    public static function create_birth_medical_data($request,$birth_id,$patient_id){
        BirthMedicalDataBaby::create(self::fill_data($request,$birth_id,$patient_id));
    }

    private static function fill_data($request,$birth_id,$patient_id){
        return [
            'birth_id'=>$birth_id,
            'patient_id'=>$patient_id,
            'gender'=>$request['gender'],
            'modus'=>$request['modus'],
            'weight'=>$request['weight'],
            'head'=>$request['head'],
            'chest'=>$request['chest'],
            'arm'=>$request['arm'],
            'length'=>$request['length'],
            'apgar'=>$request['apgar'],
            'vit_k'=>$request['vit_k'],
            'E1'=>$request['E1'],
            'malformation'=>$request['malformation'],
            'infection'=>$request['infection'],
            'correlation'=>$request['correlation'],
            'extra_supervision_needed'=>$request['extra_supervision_needed'],
            'cpa_needed'=>$request['cpa_needed'],
            'swobs_taken'=>$request['swobs_taken'],
            'baby_not_crying'=>$request['baby_not_crying'],
            'risk_of_cerebral_palsy'=>$request['risk_of_cerebral_palsy'],
            'alive'=>$request['alive'],
            'death_explanation'=>$request['death_explanation']
        ];
    }
}
