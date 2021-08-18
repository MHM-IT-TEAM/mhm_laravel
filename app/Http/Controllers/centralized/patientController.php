<?php

namespace App\Http\Controllers\centralized;

use App\Http\Controllers\Controller;
use App\Http\Requests\patientRequest;
use App\Models\Patient;
use App\Service\PatientService;
use Illuminate\Http\Request;

class patientController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }

    public function store(patientRequest $request)
    {

     $patService=new PatientService($request);
        return $patService ->store();
        dd($request->all());
    }

    public function show($id)
    {
        return Patient::find($id);
    }

    public function edit($id)
    {
        $patient= Patient::find($id);
        if ($patient) {
            $dueSum= $patient->patient_due()->get();
            $value=count($dueSum)>0?intval($dueSum[0]["amount"]):0;
            return [
                "patient"=>$patient,
                "dueSum"=>$value,
                "success"=>true
            ];
        }
        else
        {
            return response()->json([ "message"=>"No patient found","success"=>false ]);
        }
    }
    public function update(Request $request, $id)
    {
        $patService=new PatientService($request);
        return $patService->update($id);
    }

    public function destroy($id)
    {
        return Patient::find($id)->delete();
    }
    public function search(Request $request){
        $patient= new Patient();
        $query = $request->get('query');
        $queryWords = explode(' ', $query, 8);
        return $patient->search($queryWords)->get();
    }
    public function vitalSign($id){
        return Patient::find($id)->vitalSigns()->latest()->take(1)->get();

    }
    public function filter(Request $request){
        $patient= new Patient();
        return $patient->filter($request);
    }
}
