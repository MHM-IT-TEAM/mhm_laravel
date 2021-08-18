<?php

namespace App\Http\Controllers\V1\consultation;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
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
        //
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
}
