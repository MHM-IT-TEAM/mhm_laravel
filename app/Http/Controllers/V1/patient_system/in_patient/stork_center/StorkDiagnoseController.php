<?php

namespace App\Http\Controllers\V1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Models\StorkDiagnose;
use Illuminate\Http\Request;

class StorkDiagnoseController extends Controller
{
    public function store(Request $request){
        StorkDiagnose::create([
            'stork_admission_id'=>$request->stork_admission_id,
            'type'=>$request->type,
            'time'=>$request->time,
            'diagnose'=>$request->diagnose,
            'user'=>$request->user
        ]);
        return response()->success();
    }
    public function show($id){
        return StorkDiagnose::where('stork_admission_id',$id)->get();
    }
    public function last_diagnose($stork_admission_id){
        return StorkDiagnose::where('stork_admission_id',$stork_admission_id)->latest()->first();
    }

}
