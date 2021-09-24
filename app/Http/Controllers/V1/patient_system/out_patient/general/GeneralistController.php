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
        return Admission::with(['generalist','graceCsbTransaction'=>function($transaction){
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
}
