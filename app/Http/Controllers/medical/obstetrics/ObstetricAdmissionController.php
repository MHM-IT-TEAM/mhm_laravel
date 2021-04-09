<?php

namespace App\Http\Controllers\medical\obstetrics;

use App\Http\Controllers\Controller;
use App\Service\CpnAdmissionService;
use Illuminate\Http\Request;

class ObstetricAdmissionController extends Controller
{
    public function store(Request $request){
        $admission=new CpnAdmissionService();
        $admission->store($request);

    }
    public function code(){
        $code= new CpnAdmission();
        return $code->id;
    }
}
