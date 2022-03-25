<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\obstetrical;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\CpnFollowup;
use App\Models\CpnAdmission;
use App\Models\Admission;
use App\Service\Medical\obstetrics\CpnFollowupService;
use App\Service\Medical\obstetrics\UltrasoundService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CpnFollowupController extends Controller
{
    protected $service;
    protected $ultrasoundService;

    public function __construct(){
        $this->service= new CpnFollowupService();
        $this->ultrasoundService = new UltrasoundService();
    }

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
        $service= new CpnFollowupService();
        return $service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return CpnAdmission::with(['followups','patient'])->find($id);
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

        return $this->service->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function get_recent_cpn_admissions_for_patient($patient_id) {
        return CpnAdmission::where('patient_id',$patient_id)->latest()->first();
    }
}
