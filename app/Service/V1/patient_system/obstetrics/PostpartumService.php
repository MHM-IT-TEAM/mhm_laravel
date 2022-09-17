<?php


namespace App\Service\V1\patient_system\obstetrics;


use App\Models\Admission;
use App\Models\GraceCsbTransaction;
use App\Models\GraceCsbTransactionDetail;
use App\Models\Postpart;
use Illuminate\Database\Eloquent\Model;

class PostpartumService
{
    public function store($request){
        $checkup= new Postpart();
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
            'diagnose'=>$request->diagnose,
            'eyes'=>$request->eyes,
            'legs'=>$request->legs,
            'bp'=>$request->bp,
            'perineum'=>$request->perineum,
            'woundcare'=>$request->woundcare,
            'breast'=>$request->breast_size,
            'belly_size'=>$request->belly_size,
            'uterus_size'=>$request->belly_size,
            'bleeding'=>$request->bleeding,
            'urine'=>$request->urine,
            'kacka'=>$request->kacka,
        ];
    }
}
