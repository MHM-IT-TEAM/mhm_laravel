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

//        $patService=new PatientService($request);
//        return $patService ->store();
//        dd($request->all());
        $patient= new Patient();
        return $patient->where('firstName','LIKE',"%".$request->firstName."%")
            ->where('lastName','LIKE',"%".$request->lastName."%")
            ->where('gender',$request->gender)
            ->get();
    }

    public function show($id)
    {
        return Patient::find($id);
    }

    public function edit($id)
    {
        $patient= Patient::find($id);
        if ($patient) {
            return [
                "patient"=>$patient,
                "dueSum"=>$patient->patient_due()->get("amount")
            ];
        }
        else
        {
            return response()->json([ "message"=>"No patient found" ]);
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
}
