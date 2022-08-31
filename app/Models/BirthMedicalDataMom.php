<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthMedicalDataMom extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function fill_data($request,$birth_id){
//        $complications='';
//        if(count($request['complications'])>0){
//            foreach($request['complications'] as $compl){
//                $complications.= $compl.',';
//            }
//            $complications= rtrim($complications,',');
//        }
        return [
            'birth_id'=>$birth_id,
            'position'=>$request['position'],
            'blood_loss'=>$request['blood_loss'],
            'anesthesia'=>$request['anesthesia'],
            'stiches'=>$request['stiches'],
            'placenta_time'=>$request['placenta_time'],
            'placenta_complete'=>$request['placenta_complete'],
            'placenta_spontaneous'=>$request['placenta_spontaneous'],
            'placenta_manual_delivery'=>$request['placenta_manual_delivery'],
            'placenta_curetage'=>$request['placenta_curetage'],
            'supervision_needed'=>$request['supervision_needed'],
            'ctg'=>$request['ctg'],
            'complication_mom_before_birth'=>$request['complication_mom_before_birth'],
            'complication_mom_after_birth'=>$request['complication_mom_after_birth'],
            'remarks'=>$request['remarks'],
            'sterilisation_package'=>$request['sterilisation_package'],
            'stitches_package'=>$request['stitches_package'],
        ];
    }
    public static function create_medical_data($request,$birth_id){
        BirthMedicalDataMom::create(self::fill_data($request,$birth_id));
    }
}
