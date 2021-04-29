<?php

namespace App\Http\Controllers\hospitalisation;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\HospitalService;
use App\Models\HospitalServiceDivision;
use Illuminate\Http\Request;

class hospitalAdmissionController extends Controller
{
    public function service_list(){
        return HospitalService::all();
    }
    public function division_list($service_id){
        $div= new HospitalServiceDivision();
        return $div->whereService($service_id)->get();
    }
    public function bed_list($division_id){
        $bed= new Bed() ;
        return $bed->whereDivision($division_id);

    }
}
