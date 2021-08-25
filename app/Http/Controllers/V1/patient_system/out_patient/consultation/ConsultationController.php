<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\consultation;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\PatientCareDetail;
use App\Service\ConsultationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        return Consultation::all();
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

    public function destroy($id)
    {
        //delete care_details
        PatientCareDetail::where('consultation_id',$id)->delete();
        //delete consultations
        Consultation::find($id)->delete();
    }
    public function all_with_patient_details(){
        return Consultation::with(['patient'])->get();
    }
    public function all_with_care_details(){
        return Consultation::with(['patient','patientCareDetails'=>function($det){return $det->with('servicePrices');},'typeConsult'])->get();
    }
    public function today_consultation_by_type($type){
        $consultation=new Consultation();
        $response= $consultation->with(['patient','patientCareDetails'=>function($det){return $det->with('servicePrices');},'typeConsult'])->todayConsultation();
        if($type==0) {
            $response=$response->get();
        }else{
            $response = $response->type($type)->get();
        }
        return $response;
    }
    public function filter_by_date_and_type($date,$type){
        $consultation=new Consultation();
        return $consultation->date($date)->type($type)->get();
    }
    public function filter_by_month_and_type($month,$type){
        return Consultation::whereDate('created_at',$month)->where('type_consult_id',$type);
    }
    public function check_patient_today_consultation(Request $request){
        return Consultation::where('type_consult_id',$request->type_consult_id)->where('patient_id',$request->patient_id)->whereDate('created_at',\Illuminate\Support\Carbon::today())->get();
    }
}
