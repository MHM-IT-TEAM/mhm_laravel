<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generalist extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];

    //relationships
        public function consultation(){
            return $this->belongsTo(Consultation::class);
        }
        public function generalistMedication(){
            return $this->hasMany(GeneralistMedication::class);
        }


    public function store($request){
//            dd($request->get('medication'));
        $this->fill($this->_fill_main_data($request))->save();
        $generalist_id= $this->id;
        if(count($request->get('medication'))>0){

        }

    }

    private function _fill_main_data($request){
            return [
                'consultation_id'=>$request->consultation['id'],
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
    private function _medicines_transaction($request,$consultation_id){
        $transaction= new GraceCsbTransaction();
        $transaction->create([
            'consultation_id'=>$consultation_id,
            'done'=>0
            ]);
        $details='';
    }
}
