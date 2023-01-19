<?php

namespace App\Http\Controllers\v1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Models\StorkPlan;
use App\Service\V1\patient_system\in_patient\StorkPlanService;
use Illuminate\Http\Request;

class StorkPlanController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plan = new StorkPlanService();
        return $plan->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return StorkPlan::with('stork_plan_details')->where('stork_admission_id',$id)->orderBy('created_at',"desc")->get();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service= new StorkPlanService();
        $service->destroy($id);
    }

    public function update_showInProjection($id, $showInProjection){
        $service= new StorkPlanService();
        $service->update_showInProjection($id, $showInProjection);

    }
}
