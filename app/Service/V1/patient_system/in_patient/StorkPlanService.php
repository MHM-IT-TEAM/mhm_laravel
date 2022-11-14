<?php


namespace App\Service\V1\patient_system\in_patient;


use App\Models\StorkPlan;
use App\Models\StorkPlanDetail;
use Illuminate\Support\Facades\DB;

class StorkPlanService
{
    public function store($request){
       return DB::transaction(function() use($request){
            $sp=StorkPlan::create([
                'stork_admission_id'=>$request->stork_admission_id,
                'user_id'=>$request->user_id,
                'laboratory'=>$request->laboratory,
                'when'=>$request->when
            ]);
            foreach($request->to_do as $row){
                StorkPlanDetail::create([
                    'stork_plan_id'=>$sp->id,
                    'to_do'=>$row['to_do'],
                    'to_do_frequency'=>$row['frequency'],
                    'type'=>$row['type'],
                    'day'=>$row['day']
                ]);
            }
            return response()->json(['success'=>true]);
        });

//        StorkPlan::create([
//            'stork_admission_id'=>$request->stork_admission_id,
//            'user_id'=>$request->user_id,
//            'comment'=>$request->comment,
//            'when'=>$request->when
//        ]);
    }
}
