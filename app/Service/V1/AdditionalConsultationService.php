<?php


namespace App\Service\V1;


use App\Models\AdditionalConsultation;
use App\Models\Admission;

class AdditionalConsultationService
{
    public function store($request){
//        dd($request->all());
        //create a new admission
        $adm=Admission::create([
            'patient_id'=>$request->admission['patient_id'],
            'category_id'=>$request->category_id,
            'service_id'=>$request->service_id,
            'service_activity_id'=>$request->service_activity_id,
            'user_id'=>$request->user['id'],
            'temp'=>$request->admission['temp'],
            'taSysto'=>$request->admission['taSysto'],
            'taDia'=>$request->admission['taDia'],
            'pulse'=>$request->admission['pulse'],
            'spo2'=>$request->admission['spo2'],
            'status'=>'RUNNING',
            'payment_status'=>'PAID',//to bypass the cash system
            'admission_type_id'=>3,
            'remark'=>$request->reason_for_consultation
        ]);
        //insert to internalReferral table
        AdditionalConsultation::create([
            'from_admission_id'=>$request->admission['id'],
            'to_admission_id'=>$adm->id,
            'user_id'=>$request->user['id'],
            'reason_for_consultation'=>$request->reason_for_consultation
        ]);
        return response()->json(['success'=>true,'data'=>$adm]);
    }

}
