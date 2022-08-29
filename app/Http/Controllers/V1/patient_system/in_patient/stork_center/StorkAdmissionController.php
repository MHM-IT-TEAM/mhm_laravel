<?php

namespace App\Http\Controllers\V1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\StorkAdmission;
use App\Service\V1\patient_system\in_patient\StorkAdmissionService;
use Illuminate\Http\Request;

class StorkAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StorkAdmission::with(['bed','patient','admission','stork_diagnoses'])->whereNull('dismissed')->get();

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
        $admission= new StorkAdmissionService();
        return $admission->store($request);
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
    public function in_patient_book(){
        return StorkAdmission::with(['patient','stork_dismissal','service'])->get();
    }
    public function change_bed(Request $request){
        $stork_admission= StorkAdmission::find($request->stork_admission_id);
        $stork_admission->bed_id= $request->destination_bed;
        $stork_admission->save();
        $bed_free= Bed::find($request->source_bed);
        $bed_free->occupied=0;
        $bed_free->save();
        $bed_occupied=Bed::find($request->destination_bed);
        $bed_occupied->occupied=1;
        $bed_occupied->save();
        return response()->json(['success'=>true]);
    }
    public function update_admission_by_ir(Request $request){

        $stork_admission= StorkAdmission::where('admission_id',$request->admission['id'])->first();
        $stork_admission->update(['dismissed'=>1]);
        $bed= Bed::find($stork_admission->bed_id);
        $bed->occupied=0;
        $bed->save();
    }
}
