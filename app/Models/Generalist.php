<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generalist extends Model
{
    use HasFactory;

    protected $guarded=[];

    //relationships
        public function admission(){
            return $this->belongsTo(Admission::class);
        }
        public function generalistMedication(){
            return $this->hasMany(GeneralistMedication::class);
        }
        public function generalistDiagCodes(){
            return $this->hasMany(GeneralistDiagCode::class);
        }


    public function store($request){
//        dd($request);
        $this->fill($this->_fill_main_data($request))->save();
        if(count($request->get('medication'))>0){
            $this->_medicines_transaction($request->get('medication'),$request->admission['id']);
        }
        if(count($request->get('diag_codes'))>0){
            GeneralistDiagCode::store($request->get('diag_codes'),$this->id);
        }
        $admission= Admission::find($request->admission['id']);
        $admission->status='DONE';
        $admission->save();
    }

    private function _fill_main_data($request){
            return [
                'admission_id'=>$request->admission['id'],
                'new_case'=>intval($request->new_case),
                'symptoms'=>$request->symptoms,
                'body_check'=>$request->body_check,
                'appointment'=>$request->appointment,
                'taDia'=>$request->taDia,
                'taSysto'=>$request->taSysto,
                'temp'=>$request->temp,
                'pulse'=>$request->pulse,
                'weight'=>$request->weight,
                'spo2'=>$request->spo2,
                'vaccination'=>intval($request->vaccination),
                'internal_lab'=>intval($request->internal_lab),
                'external_lab'=>intval($request->external_lab),
                'internal_consultation'=>intval($request->internal_consultation),
                'external_consultation'=>intval($request->external_consultation),
                'wound_care'=>intval($request->wound_care),
                'stitches'=>intval($request->stitches),
                'nebulizer'=>intval($request->nebulizer),
                'outcome'=>$request->outcome,
                'responsible'=>$request->responsible
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
