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
            'diagnose'=>$request->diagnose
        ]);
        return response()->success();
    }
    public function show($id){
        return StorkDiagnose::where('stork_admission_id',$id)->get();
    }
}
