<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\obstetrical;

use App\Http\Controllers\Controller;
use App\Models\BabyCheckup;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;

class BabyCheckupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('medical.obstetrics.pink.babies.weight_overview');
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
        $checkup= new BabyCheckup();
        $checkup->fill($this->fill_data($request))->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return  Patient::with(['babyCheckups','birth_medical_data'])->find($id);
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

    private function fill_data($request){
        return [
            'consultation_id'=>$request->consultation_id,
            'gl_impression'=>$request->gl_impression,
            'weight'=>$request->weight,
            'umbilic'=>$request->umbilic,
            'skin'=>$request->skin,
            'other'=>$request->other,
            'precautions'=>$request->precautions
        ];
    }
}
