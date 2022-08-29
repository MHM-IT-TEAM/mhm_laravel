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
            'apgar_1'=>$request['apgar_1'],
            'apgar_2'=>$request['apgar_2'],
            'apgar_3'=>$request['apgar_3'],
            'vit_k'=>$request['vit_k'],
            'E1'=>$request['E1'],
            'malformation'=>$request['malformation'],
            'malformation_explanation'=>$request['malformation_explanation'],
            'position'=>$request['position'],
            'infection'=>$request['infection'],
            'correlation'=>$request['correlation'],
            'extra_supervision_needed'=>$request['extra_supervision_needed'],
            'cpa_needed'=>$request['cpa_needed'],
            'swobs_taken'=>$request['swobs_taken'],
            'baby_not_crying'=>$request['baby_not_crying'],
            'risk_of_cerebral_palsy'=>$request['risk_of_cerebral_palsy'],
            'alive'=>$request['alive'],
            'death_explanation'=>$request['death_explanation'],
            "complication_before_birth"=>$request[ "complication_before_birth"],
            "complication_after_birth"=>$request[ "complication_after_birth"],
        ];
    }
}
