<?php


namespace App\Service\V1\patient_system\obstetrics;


use App\Models\Admission;
use App\Models\GraceCsbTransaction;
use App\Models\GraceCsbTransactionDetail;
use App\Models\MilkprogramFollowup;
use App\Models\MilkprogramFollowupDetail;
use Illuminate\Database\Eloquent\Model;

class MilkProgramService
{
    public function store_followup($request){

        $fup= new MilkprogramFollowup();
        $fup->fill($this->_fillFollowup($request));
        $fup->save();
        foreach($request->medication as $milk){
            $fup_det= new MilkprogramFollowupDetail();
            $fup_det->create($this->_fillFollowupDetail($milk,$fup->id));
        }
        if(count(collect($request->medication))>0){
            $this->_medicines_transaction($request->medication,$request->admission_id);
        }
        $admission =Admission::find($request->admission_id);
        $admission->status='DONE';
        $admission->save();
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
            'item_id'=>$data['item']['id'],
            'qty'=>$data['to_give']
        ];
    }
    private function _medicines_transaction($request,$admission_id){
        $transaction= new GraceCsbTransaction();

        $transaction->admission_id=$admission_id;
        $transaction->done=0;
        $transaction->save();
        foreach($request as $line){
            $line['grace_csb_transaction_id']=$transaction->id;
            GraceCsbTransactionDetail::create_detail($line,);
        }
    }
}
