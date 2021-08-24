<?php

namespace App\Http\Controllers\medical\obstetrics;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\CpnFollowup;
use App\Service\Medical\obstetrics\CpnFollowupService;
use Illuminate\Http\Request;

class CpnFollowupController extends Controller
{
    protected $service;

    public function __construct(){
        $this->service= new CpnFollowupService();
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
        $followups = CpnFollowup::where('cpn_admission_id',$id)->get();
        $patient = Patient::whereHas('cpnAdmissions', function ($query) use($id) {
            $query->where('id', $id);
        })->first();

        return [
            'followups'=> $followups,
            'patient' => $patient
        ];
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
}
