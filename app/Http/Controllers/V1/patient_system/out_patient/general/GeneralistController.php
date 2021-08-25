<?php

namespace App\Http\Controllers\V1\medical\out_patient;

use App\Http\Controllers\Controller;
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
        return Generalist::with(['consultation'=>function($consultation){
            return $consultation->with(['graceCsbTransaction'=>
                function($transaction){
                    return $transaction->with('graceCsbTransactionDetail');
                }
            ]);
        }])->where('consultations.patient_id',$id)->get();
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
