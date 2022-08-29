<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\obstetrical;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Consultation;
use App\Models\VaccinActiveResearch;
use App\Models\VaccinAppointment;
use App\Models\vaccinRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BabyVaccinationController extends Controller
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

        vaccinRecord::create($this->fill_data($request));
        foreach($request->active_research as $research){
            $vaccin_research= new VaccinActiveResearch();
            $vaccin_research->patient_id=$request->patient['id'];
            if($research['research_date']!==null && $research['code']!==null) $vaccin_research->fill($research)->save();
        }
        foreach($request->appointment as $date){
            $appoint= new VaccinAppointment();
            $appoint->patient_id= $request->patient['id'];
            if($date['date']!==null) $appoint->fill($date)->save();
        }
        $admission= Admission::find($request->admission_id);
        $admission->status='DONE';
        $admission->save();
        return ['success'=>true];
    }
    private function fill_data($data){
        function check($a){

            if ($a==false){
                return  0;
            }elseif($a===true){
                return 1;
            }else{
                return null;
            }
        }
        return [
            'bcg'=>check($data->bcg),
            'polio0'=>check($data->polio0),
            'dtc1'=>check($data->dtc1),
            'polio1'=>check($data->polio1),
            'dtc2'=>check($data->dtc2),
            'polio2'=>check($data->polio2),
            'dtc3'=>check($data->dtc3),
            'polio3'=>check($data->polio3),
            'var1'=>check($data->var1),
            'var2'=>check($data->var2),
            'pcv1'=>check($data->pcv1),
            'pcv2'=>check($data->pcv2),
            'pcv3'=>check($data->pcv3),
            'vpi'=>check($data->vpi),
            'rota1'=>check($data->rota1),
            'rota2'=>check($data->rota2),
            'patient_id'=>$data->patient['id'],
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return VaccinRecord::where('patient_id',$id)->get();
        return response()->json([
            'vaccinRecord'=>VaccinRecord::where('patient_id',$id)->get(),
            'active_research'=>VaccinActiveResearch::where('patient_id',$id)->get(),
            'appointment'=>VaccinAppointment::where('patient_id',$id)->get()
        ]);
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
}
