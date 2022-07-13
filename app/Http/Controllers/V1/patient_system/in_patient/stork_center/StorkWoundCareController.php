<?php

namespace App\Http\Controllers\V1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Models\StorkWoundCare;
use Illuminate\Http\Request;

class StorkWoundCareController extends Controller
{
    public function store(Request $request){
        StorkWoundCare::create([
            'stork_admission_id'=>$request->stork_admission_id,
            'description'=>$request->description
        ]);
        return response()->success();
    }
    public function show($id){
        return  StorkWoundCare::where('stork_admission_id',$id)->get();
    }
}
