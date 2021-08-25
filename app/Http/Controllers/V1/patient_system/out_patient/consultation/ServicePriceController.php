<?php

namespace App\Http\Controllers\v1\patient_system\out_patient\consultation;

use App\Http\Controllers\Controller;
use App\Models\ServicePrice;
use Illuminate\Http\Request;

class ServicePriceController extends Controller
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
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function filter_per_type_sector($type_consultation,$sector){
        return ServicePrice::where('type_consult_id',$type_consultation)->where('sector',$sector);
    }
}
