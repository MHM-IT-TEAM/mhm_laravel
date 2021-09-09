<?php

namespace App\Http\Controllers\V1\patient_system\admission;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AdmissionRequest;
use App\Models\Admission;
use App\Service\Medical\obstetrics\CpnAdmissionService;
use App\Service\V1\AdmissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AdmissionController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $admission= new AdmissionService();
        return $admission->store($request);
    }
    public function show($id)
    {
        $consultation= Admission::with(['admissionCareDetails'=>function($data){
            return $data->with('activity_price')->get();
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
        $consultation= new AdmissionService();
        return $consultation->update($request,$id);
    }
    public function destroy($id)
    {
        $consultation= new AdmissionService();
        return $consultation->destroy($id);
    }
    public function list_today(){
        return Admission::whereDate('created_at',Carbon::today())
            ->with(
                [
                    'patient'=>function($patient){
                        return $patient->with('patient_due');
                    },
                     'service_activity',
                    'admissionCareDetails'=>function($data){
                        return $data->with('activity_price')->get();
                    }
                ]
            )->get();
    }
}
