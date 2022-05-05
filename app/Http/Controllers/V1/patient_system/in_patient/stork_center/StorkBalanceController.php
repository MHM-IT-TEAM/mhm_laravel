<?php

namespace App\Http\Controllers\V1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Models\StorkAdmission;
use App\Models\StorkBalance;
use App\Models\StorkBalanceIn;
use App\Models\StorkBalanceOut;
use Illuminate\Http\Request;

class StorkBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        StorkBalance::create($request->all());
        return StorkBalance::with(['storkAdmission'=>function($adm){return $adm->with('patient')->get();},'balance_ins','balance_outs'])->where('stork_admission_id',$request->stork_admission_id)->get();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return StorkAdmission::with(['balances','patient'])->find($id);
        return StorkBalance::with(['storkAdmission'=>function($adm){return $adm->with('patient')->get();},'balance_ins','balance_outs'])->find($id);
    }
    public function stork_balance_where_admission_id($id){
        return StorkBalance::with(['storkAdmission'=>function($adm){return $adm->with('patient')->get();},'balance_ins','balance_outs'])->where('stork_admission_id',$id)->get();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function store_in(Request $request){
        StorkBalanceIn::create($request->all());
    }
    public function store_out(Request $request){
        StorkBalanceOut::create($request->all());
    }
    public function close_balance(Request $request){
        $balance= StorkBalance::find($request->stork_balance_id);
        $balance->date_end= $request->date_end;
        $balance->number_of_hours= $request->number_of_hours;
        $balance->status='CLOSED';
        $balance->save();
    }
}
