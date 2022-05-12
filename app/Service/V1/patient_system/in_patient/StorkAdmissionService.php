<?php


namespace App\Service\V1\patient_system\in_patient;


use App\Models\Admission;
use App\Models\Bed;
use App\Models\StorkAdmission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StorkAdmissionService
{
    private function _fillData($src)
    {
        return [
            'new_request'=>$src->new_request,
            'changes_made'=>$src->changes_made,
            'patient_id'=>$src->patient_id,
            'admission_id'=>$src->admission_id,
            'admission_date'=>$src->admission_date,
            'admission_time'=>$src->admission_time,
            'service_id'=>$src->service_id,
            'bed_id'=>$src->bed_id,
            'level_of_care'=>$src->level_of_care,
            'admission_diagnosis'=>$src->admission_diagnosis,
            'type_of_stay'=>$src->type_of_stay,
            'infection_control_referred_patient'=>$src->infection_control_referred_patient,
            'infection_control_facility_place'=>$src->infection_control_facility_place,
            'infection_control_facility_val'=>$src->infection_control_facility_val,
            'infection_control_facility_type'=>$src->infection_control_facility_type,
            'infection_control_reason_of_hospitalisation'=>$src->infection_control_reason_of_hospitalisation,
            'infection_control_reason_of_transfer'=>$src->infection_control_reason_of_transfer,
            "estimated_stay_length"=>$src->estimated_stay_length,
            "estimated_stay_length_type"=>$src->estimated_stay_length_type,
            'temp'=>$src->temp,
            'pulse'=>$src->pulse,
            'weight'=>$src->weight,
            'bp'=>$src->bp,
            'spo2'=>$src->spo2,
            "anesthesia_required"=>$src->anesthesia_required,
            "anesthesia_type"=>$src->anesthesia_type,
            "mobilisation_status"=>$src->mobilisation_status,
            "type"=>$src->type,
            "mom"=>$src->mom,
            "meal"=>$src->meal,
            "unpaid_amount"=>$src->unpaid_amount,
        ];
    }
    public function store($request){
        //check if the data is already in the system
        $check= StorkAdmission::where('patient_id',$request->patient_id)->whereDate('created_at',Carbon::today())->first();
        if($check->exists())
        {
            return response()->json(['success'=>false,"message"=>'the patient is already saved in the system on the same date, risk of duplicate data']);
        }
        else
        {
            DB::transaction(function() use($request) {
                StorkAdmission::create($this->_fillData($request));
                //update the admission status (Done)
                $admission= Admission::find($request->admission_id);
                $admission->status='DONE';
                $admission->save();
                //update the bed
                $bed= Bed::find($request->bed_id);
                $bed->occupied=true;
                $bed->save();
            });
            return response()->json(['success'=>true]);
        }




    }
}
