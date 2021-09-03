<?php

namespace App\Http\Controllers\V1\patient_system\consultation;

use App\Http\Controllers\Controller;
use App\Models\AdmissionPriority;
use Illuminate\Http\Request;

class AdmissionPriorityController extends Controller
{

    public function index()
    {
        return AdmissionPriority::all();
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
}
