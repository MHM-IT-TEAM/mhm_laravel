<?php


namespace App\Service\V1\patient_system;


use App\Models\Admission;
use App\Models\GraceCsbTransaction;
use App\Models\GraceCsbTransactionDetail;
use App\Models\Woundcare;
use App\Models\WoundcareMaterial;
use Illuminate\Database\Eloquent\Model;

class WoundCareService
{
    public function store($request){
        $wc= new Woundcare();
        $wc->fill($this->fill_data($request))->save();
        if(count(collect($request->medication))>0){
            $this->_medicines_transaction($request->medication,$request->admission_id);
        }
        if(count(collect($request->materials))>0){
            $this->save_materials($request->materials,$wc->id);
        }
        $admission= Admission::find($request->admission_id);
        $admission->status='DONE';
        $admission->save();
        return response()->json(['success'=>true]);
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
            'diagnostic'=>$request->diagnostic,
            'description'=>$request->description,
            'appointment'=>$request->appointment,
            'user_id'=>$request->user_id,
        ];
    }
    private function save_materials($request,$woundcare_id){
        foreach($request as $data){
            WoundcareMaterial::create(
                [
                    'woundcare_id'=>$woundcare_id,
                    'material'=>$data['material'],
                    'quantity'=>$data['quantity'],
                    'unit'=>$data['unit'],
                ]
            );
        }
    }
}
