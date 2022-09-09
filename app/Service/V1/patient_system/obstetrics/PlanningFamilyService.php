<?php


namespace App\Service\V1\patient_system\obstetrics;


use App\Models\Admission;
use App\Models\FamilyPlanning;
use App\Models\GraceCsbTransaction;
use App\Models\GraceCsbTransactionDetail;
use Illuminate\Database\Eloquent\Model;

class PlanningFamilyService
{
    public function store($request){
        $checkup= new FamilyPlanning();
        $checkup->fill($this->fill_data($request))->save();
        if(count(collect($request->medication))>0){
            $this->_medicines_transaction($request->medication,$request->admission_id);
        }
        $admission= Admission::find($request->admission_id);
        $admission->status='DONE';
        $admission->save();

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
    private function fill_data($request){
        return [
            'admission_id'=>$request->admission_id,
            'patient_id'=>$request->patient_id,
            'used_method'=>$request->used_method,
            'qty'=>$request->qty,
            'remark'=>$request->remark,
            'new_user'=>$request->new_user
        ];
    }
}
