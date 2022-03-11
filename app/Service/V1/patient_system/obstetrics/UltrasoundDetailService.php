<?php


namespace App\Service\V1\patient_system\obstetrics;


use App\Models\UltrasoundDetail;

class UltrasoundDetailService
{
    public function insert_details($request){
        $data=$request->all();
        for($i=0;$i<count($request->all());$i++){
            UltrasoundDetail::create($data[$i]);
        }
        return response()->json(['success'=>true]);
    }

//    private function _fill_data($data){
//        return;
//    }
}
