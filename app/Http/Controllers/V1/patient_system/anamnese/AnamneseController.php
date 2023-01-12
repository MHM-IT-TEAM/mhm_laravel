<?php

namespace App\Http\Controllers\V1\patient_system\anamnese;

use App\Http\Controllers\Controller;
use App\Models\Anamnese;
use App\Models\VitalSign;
use Illuminate\Http\Request;

class AnamneseController extends Controller
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
        Anamnese::create([
            'admission_id'=>$request->admission_id,
            'patient_id'=>$request->patient_id,
            'anamnese'=>$request->anamnese,
            'user_id'=>$request->user_id,
        ]);
        return Anamnese::with('user')->where('patient_id',$request->patient_id)->orderByDesc('created_at')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Anamnese::with('user')->where('patient_id',$id)->orderByDesc('created_at')->get();

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
        Anamnese::find($id)->delete();
    }
}
