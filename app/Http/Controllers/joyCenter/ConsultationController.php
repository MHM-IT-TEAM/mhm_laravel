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

    public function index()
    {
        $consult= new Consultation();
        return $consult->todayConsultation()->with(['patient','typeConsult','patientCareDetails'])->get();

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $consult= new consultationService($request);
        $consult->store();
        return response()->json(['success'=>true,'msg'=>'consultation submitted successfully']);
    }

    public function show($id)
    {
        $consultation= Consultation::with(['patientCareDetails'=>function($data){
            return $data->with('servicePrices')->get();
        },'patient'=>function($patient){
            return $patient->with('patient_due');
        }])->find($id);
        return $consultation;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $cons=new ConsultationService($request);
        $cons->update($id);
        return response()->json(['success'=>true,'msg'=>'consultation updated successfully']);
    }


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
    public function filter_by_date_and_type($date,$type){
        return Consultation::whereDate('created_at',date($date))->where('type_consult_id',$type);
    }
}
