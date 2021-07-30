<?php

namespace App\Http\Controllers\centralized;

use App\Http\Controllers\Controller;
use App\Http\Requests\patientRequest;
use App\Models\Patient;
use App\Service\PatientService;
use Illuminate\Http\Request;

class patientController extends Controller
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
     * @return PatientService
     */
    public function store(patientRequest $request)
    {

        $patService=new PatientService($request);
        return $patService ->store();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Patient::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function edit($id)
    {
        $patient= Patient::find($id);
        return [
            "patient"=>$patient,
            "dueSum"=>$patient->patient_due()->get("amount")
        ];
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
        $patService=new PatientService($request);
        return $patService->update($id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Patient::find($id)->delete();
    }
    /**
     * return result based on the query
     * @param string $query
    */
    public function search(Request $request){
        $patient= new Patient();
        return $patient->search($request->get('query'))->get();
    }
    public function vitalSign($id){
        return Patient::find($id)->vitalSigns()->latest()->take(1)->get();

    }
}
