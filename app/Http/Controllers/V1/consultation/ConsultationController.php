<?php

namespace App\Http\Controllers\V1\consultation;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
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
        //
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
    public function all_with_patient_details(){
        return Consultation::with(['patient'])->get();
    }
    public function all_with_care_details(){
        return Consultation::with(['patient','patientCareDetails'=>function($det){return $det->with('servicePrices');},'typeConsult'])->get();
    }
    public function today_consultation_by_type($type){
        $consultation=new Consultation();
        return $consultation->with(['patient','patientCareDetails'=>function($det){return $det->with('servicePrices');},'typeConsult'])->todayConsultation()->type($type)->get();
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
