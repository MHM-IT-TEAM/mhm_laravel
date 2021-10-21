<?php


namespace App\Service\V1;


use App\Models\Admission;
use App\Models\InternalReferral;

class InternalReferralService
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
            'admission_type_id'=>2,
        ]);
        //insert to internalReferral table
        InternalReferral::create([
            'from_admission_id'=>$request->admission['id'],
            'to_admission_id'=>$adm->id,
            'user_id'=>$request->user['id'],
            'reason_for_transfer'=>$request->reason_for_transfer
        ]);
        return response()->json(['success'=>true]);
    }
}
