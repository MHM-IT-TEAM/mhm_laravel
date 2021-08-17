<?php

namespace App\Http\Controllers\joyCenter;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\PatientCareDetail;
use App\Models\VitalSign;
use App\Service\ConsultationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $consult= new Consultation();
        return $consult->todayConsultation()->with(['patient','typeConsult','patientCareDetails'])->get();

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
        $consult= new consultationService($request);
        $consult->store();
        return response()->json(['success'=>true,'msg'=>'consultation submitted successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consultation= Consultation::with(['patientCareDetails'=>function($data){
            return $data->with('servicePrices')->get();
        },'patient'=>function($patient){
            return $patient->with('patient_due');
        }])->find($id);
        return $consultation;
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
        $cons=new ConsultationService($request);
        $cons->update($id);
        return response()->json(['success'=>true,'msg'=>'consultation updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //delete care_details
        PatientCareDetail::where('consultation_id',$id)->delete();
        //delete consultations
        Consultation::find($id)->delete();
    }
    public function check_today_consultation(Request $request){
        return Consultation::where('type_consult_id',$request->type_consult_id)->where('patient_id',$request->patient_id)->where('created_at',\Illuminate\Support\Carbon::today())->get();
    }
}
