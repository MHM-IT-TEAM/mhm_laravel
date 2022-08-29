<?php


namespace App\Service\V1\patient_system\obstetrics;


use App\Models\Admission;
use App\Models\BabyCheckup;
use App\Models\GraceCsbTransactionDetail;
use App\Models\inventory_system\GraceCsbTransaction;
use Illuminate\Database\Eloquent\Model;

class BabyCheckupService
{
    public function store($request){
        $checkup= new BabyCheckup();
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
            'gl_impression'=>$request->gl_impression,
            'weight'=>$request->weight,
            'umbilic'=>$request->umbilic,
            'skin'=>$request->skin,
            'other'=>$request->other,
            'precautions'=>$request->precautions
        ];
    }
}
