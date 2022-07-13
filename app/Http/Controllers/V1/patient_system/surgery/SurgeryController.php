<?php

namespace App\Http\Controllers\v1\patient_system\surgery;

use App\Exports\SurgeryExport;
use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\CancelledSurgery;
use App\Models\Surgery;
use App\Service\V1\SurgeryService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SurgeryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Surgery::with(['admission.patient','surgery_used_medicines'])->get();
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
        $surgery= new SurgeryService();
        return $surgery->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Surgery::with(['admission.patient','surgery_used_medicines'])->find($id);
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
        $surgery=  new SurgeryService();
        return $surgery->update($id,$request);
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
    public function export(){
        return Excel::download(new SurgeryExport(), 'surgery_list.xlsx');
    }
    public function cancel(Request $request){
        $surgery= new CancelledSurgery();
        $surgery->create(
            [
                'admission_id'=>$request->admission_id,
                'patient_id'=>$request->patient_id,
                'reason_for_cancellation'=>$request->reason_for_cancellation
            ]
        );
        $admission= Admission::find($request->admission_id);
        $admission->status='CANCELLED';
        $admission->save();
        return response()->json(['success'=>true]);
    }
}
