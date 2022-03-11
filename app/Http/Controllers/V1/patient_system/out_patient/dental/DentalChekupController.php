<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\dental;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\AdmissionCareDetail;
use App\Models\DentalCheckup;
use App\Models\DentalTreatment;
use App\Models\GraceCsbTransactionDetail;
use App\Models\inventory_system\GraceCsbTransaction;
use App\Service\V1\DentalService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class DentalChekupController extends Controller
{
    private $dental_service;
    public function __construct(){
        $this->dental_service= new DentalService();
    }
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

        return $this->dental_service->store($request);
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
        return $this->dental_service->update($request,$id);
    }

    public function destroy($id)
    {
        //
    }
    public function patient_last_checkup($patient_id){
        $result= DB::table('dental_checkups')
            ->select('*')
            ->where('patient_id',$patient_id)
            ->orderByDesc('created_at')
            ->get();
        if(count($result)>0) return response()->json($result[0]);
    }
    public function send_to_cashier(Request $request){
        $dental_service= new DentalService();
        return $dental_service->send_to_cashier($request);
    }

}
