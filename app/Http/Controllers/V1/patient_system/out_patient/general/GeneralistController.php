<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\general;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Generalist;
use Illuminate\Http\Request;

class GeneralistController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $process= new Generalist();
        $process->store($request);
        return response()->json(['success'=>true,'msg'=>'Data submitted']);
    }

    public function show($id)
    {
        return Admission::with(['patient','generalist'=>function($gl){return $gl->with(['generalistDiagCodes'=>function($code){return $code->with('diagCode')->get();}])->get();},'graceCsbTransaction'=>function($transaction){
            $transaction->with(['graceCsbTransactionDetail'=>function($det){return $det->with('item')->get();}])->get();
        }])->where('patient_id',$id)->get();
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function overview($admission_id){
        $data=Admission::with(['generalist'=>function($gl){return $gl->with('generalistDiagCodes')->get();},'graceCsbTransaction'=>function($transaction){
            $transaction->with(['graceCsbTransactionDetail'=>function($det){return $det->with('item')->get();}])->get();
        }])->find($admission_id);
        return view('medical/generalist/generalist_overview')->with('data',$data);
    }
}
