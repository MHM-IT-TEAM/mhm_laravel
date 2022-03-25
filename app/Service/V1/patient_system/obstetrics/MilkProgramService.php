<?php


namespace App\Service\V1\patient_system\obstetrics;


use App\Models\MilkprogramFollowup;
use App\Models\MilkprogramFollowupDetail;

class MilkProgramService
{
    public function store_followup($request){

        $fup= new MilkprogramFollowup();
        $fup->fill($this->_fillFollowup($request));
        $fup->save();
        foreach($request->milk_given as $milk){
            $fup_det= new MilkprogramFollowupDetail();
            $fup_det->create($this->_fillFollowupDetail($milk,$fup->id));
        }
        return response()->json(
            ['success'=>true]
        );
    }
    private function _fillFollowup($data){
        return [
            'milkprogram_admission_id'=>$data->milkprogram_admission_id,
            'weight'=>$data->weight,
            'remark'=>$data->remark
        ];
    }
    private function _fillFollowupDetail($data,$fup_id){
        return [
            'milkprogram_followup_id'=>$fup_id,
            'item_id'=>$data['milk']['id'],
            'qty'=>$data['qty']
        ];
    }
}
