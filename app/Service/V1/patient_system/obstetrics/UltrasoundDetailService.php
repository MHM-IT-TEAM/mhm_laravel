<?php


namespace App\Service\V1\patient_system\obstetrics;


use App\Models\Admission;
use App\Models\UltrasoundDetail;

class UltrasoundDetailService
{
    public function insert_details($request){
        $id=$request->all()[0]['admission_id'];
        $data=$request->all();

        for($i=0;$i<count($request->all());$i++){
            unset($data[$i]['admission_id']);
            UltrasoundDetail::create($data[$i]);
        }
        $admission=Admission::find($id);
        $admission->status='DONE';
        $admission->save();
        return response()->json(['success'=>true]);
    }
}
