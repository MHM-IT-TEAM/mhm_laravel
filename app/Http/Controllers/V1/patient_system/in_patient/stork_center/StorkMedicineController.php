<?php

namespace App\Http\Controllers\V1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Models\StorkMedicine;
use Illuminate\Http\Request;

class StorkMedicineController extends Controller
{
    public function give_medicine(Request $request){
        $med = new StorkMedicine();
        foreach($request->list as $list){
            $med->create(
                [
                    'stork_admission_id'=>$request->stork_admission_id,
                    'time'=>$list['time'],
                    'item_id'=>$list['item']['id'],
                    'qty'=>$list['given'],
                    'user'=>$request->user
                ]
            );
        }
        return response()->success();
    }
    public function show($id){
        return StorkMedicine::with('item')->where('stork_admission_id',$id)->orderBy('created_at','desc')->get();
    }
}
