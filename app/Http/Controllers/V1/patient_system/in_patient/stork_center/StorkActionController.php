<?php

namespace App\Http\Controllers\V1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Models\StorkAction;
use Illuminate\Http\Request;

class StorkActionController extends Controller
{
    public function store(Request $request){
        StorkAction::create([
            'stork_admission_id'=>$request->stork_admission_id,
            'stork_action_group_id'=>$request->stork_action_group_id,
            'value'=>$request->value,
            'user'=>$request->user,
        ]);
        return response()->success();
    }
    public function show($stork_admission_id,$action_type){
      return StorkAction::where('stork_admission_id',$stork_admission_id)->with(['storkActionGroup'=>function($query) use($action_type){
          return $query->where('type',$action_type)->get();
      }])->orderBy('created_at','desc')->get();
    }
}
