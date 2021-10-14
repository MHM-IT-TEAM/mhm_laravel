<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalLabResult extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function internalLabRequest(){
        return $this->belongsTo(InternalLabRequest::class);
    }


    public function store($request){
//              dd($request->all());
        foreach($request->blood_test as $bd){
            foreach($bd as $test){
                $this[$test['db_name']]=$test['result'];
            }
        }
        foreach($request->urine_test as $ut){
            foreach($ut['children'] as $child){
                $this[$child['db_name']]=$child['result'];
            }
        }
        $this->internal_lab_request_id=$request->internal_lab_request_id;
        $this->remark=$request->remark;
        $this->user_id=$request->user_id;
        $this->save();

        $lab_request= InternalLabRequest::find($request->internal_lab_request_id);
        //result avalaible
        $lab_request->lab_work_step_id=3;
        $lab_request->save();
    }
}
