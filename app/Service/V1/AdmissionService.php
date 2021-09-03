<?php


namespace App\Service\V1;


use App\Http\Requests\V1\AdmissionRequest;
use App\Models\Admission;
use App\Models\PatientCareDetail;
use Illuminate\Http\Request;

class AdmissionService
{
    public function store($request){
        $admission= Admission::create($this->_fill_admission_data($request));

        if(isset($request->get('patient_care_details')['id'])){
            $care_details=$request->get('patient_care_details');
            PatientCareDetail::create(
                [
                    'admission_id'=>$admission->id,
                    'activity_price_id'=>$care_details['id'],
                    'qty'=>1,
                    'total'=>$care_details['price']
                ]
            );
        }
        return response()->json([
            'success'=>true,
            'msg'=>'Data saved'
        ]);
    }
    private function _fill_admission_data($request){
        return [
            'patient_id'=>$request->patient_id,
            'service_activity_id'=>$request->service_activity_id,
            'user_id'=>$request->user_id,
            'admission_priority_id'=>$request->admission_priority_id,
            'status'=>$request->status,
            'pharmacy_status'=>$request->pharmacy_status,
            'payment_status'=>$request->payment_status,
            'provisional_diagnosis'=>$request->provisional_status,
            'temp'=>$request->temp,
            'weight'=>$request->weight,
            'taSysto'=>$request->taSysto,
            'taDia'=>$request->taDia,
            'pulse'=>$request->pulse,
            'spo2'=>$request->spo2,
            'remark'=>$request->remark,
        ];
    }
}
