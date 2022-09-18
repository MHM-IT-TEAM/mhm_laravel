<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalLabRequest extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime:d-M-Y',
    ];

    public function admission(){
        return $this->belongsTo(Admission::class);
    }
    public function lab_work_step(){
        return $this->belongsTo(LabWorkStep::class);
    }
    public function internalLabResults(){
        return $this->hasMany(InternalLabResult::class);
    }


    public function store($request){
//      dd($request->all());
        foreach($request->blood_test as $bd){
            foreach($bd as $test){
                $this[$test['db_name']]=$test['checked'];
            }
        }
        foreach($request->epoc as $epoc){
            foreach($epoc as $test){
                $this[$test['db_name']]=$test['checked'];
            }
        }
        foreach($request->urine_test as $ut){
            foreach($ut['children'] as $child){
                $this[$child['db_name']]=$child['checked'];
            }
        }
        $this->admission_id=$request->admission_id;
        $this->remark=$request->remark;
        $this->lab_work_step_id=4;
        $this->user_id=$request->user_id;
        $this->save();
    }
}
