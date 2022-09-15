<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\obstetrical;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\MilkprogramAdmission;
use App\Models\Patient;
use App\Service\V1\patient_system\obstetrics\MilkProgramService;
use Illuminate\Http\Request;

class BabyMilkProgramController extends Controller
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
        $mp= new MilkprogramAdmission();
        $mp->admission_id=$request->admission_id;
        $mp->patient_id=$request->patient_id;
        $mp->story=$request->story;
        $mp->mom_id=$request->mom_id;
        $mp->mom_is_patient=$request->mom_is_patient;
        $mp->mhm_baby=$request->mhm_baby;
        $mp->save();
        $admission =Admission::find($request->admission_id);
        $admission->status='DONE';
        $admission->save();
        return $mp;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function show_patient_milk_pro_admission($id){
        return Patient::with(['milkProgramAdmission'=>function($adm){
            return $adm->with(['milkprogramFollowups'=>function($fup){
                return $fup->with(['milkProgramFollowupDetails'=>function($det){
                    return $det->with('item')->get();
                }])->get();
            }])->get();
        }])->find($id);
    }
    public function store_followup(Request $request){
        $mp= new MilkProgramService();
        return $mp->store_followup($request);
    }
}
