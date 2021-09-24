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


    public function store($request){
        $this->fill($this->_fill_main_data($request))->save();
        if(count($request->get('medication'))>0){
            $this->_medicines_transaction($request->get('medication'),$request->admission['id']);
        }
        $admission= Admission::find($request->admission['id']);
        $admission->status='DONE';
        $admission->save();
    }

    private function _fill_main_data($request){
            return [
                'admission_id'=>$request->admission['id'],
                'new_case'=>intval($request->new_case),
                'complaint'=>$request->complaint,
                'finding'=>$request->finding,
                'diagnose'=>$request->diagnose,
                'diag_code'=>$request->diag_code,
                'details'=>$request->details,
                'appointment'=>$request->appointment,
                'malaria'=>$request->malaria,
                'syphilis'=>$request->syphilis,
                'hiv'=>$request->hiv,
                'medical_care_needed'=>intval($request->medical_care_needed),
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
