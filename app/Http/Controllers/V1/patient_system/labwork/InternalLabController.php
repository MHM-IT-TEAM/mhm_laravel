<?php

namespace App\Http\Controllers\V1\patient_system\labwork;

use App\Http\Controllers\Controller;
use App\Models\InternalLabRequest;
use App\Models\InternalLabResult;
use Illuminate\Http\Request;

class InternalLabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InternalLabRequest::with(['admission'=>function($data){return $data->with(['patient','service','service_activity'])->get();},'lab_work_step','internalLabResults'])->get();
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
        $lab= new InternalLabRequest();
        $lab->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
    public function open_request(Request $request){
        $lab = InternalLabRequest::find($request->id);
        $lab->lab_work_step_id=1;
        $lab->save();
        return true;
    }
    public function save_result(Request $request){
        $result= new InternalLabResult();
        return $result->store($request);

    }
}
