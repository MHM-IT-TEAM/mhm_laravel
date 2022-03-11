<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalTreatment extends Model
{
    use HasFactory;
    public function admission (){
        return $this->belongsTo(Admission::class);
    }
    public static function save_todo_for_today($request,$admission_id,$patient_id){
        $care=[];
        $extraction=[];
        $cleaning=false;
        foreach($request as $item){
            if(!empty($item)){
                foreach($item as $det){
                    switch ($det['diagnostic']['value']){
                        case "care":
                            $care[]=$det['id'];
                            break;
                        case "extraction":
                            $extraction[]= $det['id'];
                            break;
                        case "cleaning":
                            $cleaning=true;
                            break;
                    }
                }
            }
        }
        $checkup = new DentalTreatment();
        $checkup->admission_id=$admission_id;
        $checkup->patient_id=$patient_id;
        $checkup->extraction=collect($extraction)->implode("-");
        if($cleaning) $checkup->cleaning_necessary=true;
        $checkup->care=collect($care)->implode("-");
        $checkup->save();
        return response()->json(['success'=>true]);
    }



}
