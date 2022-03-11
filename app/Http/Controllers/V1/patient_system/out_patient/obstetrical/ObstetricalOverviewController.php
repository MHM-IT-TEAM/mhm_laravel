<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\obstetrical;

use App\Http\Controllers\Controller;
use App\Models\CpnAdmission;
use App\Service\Medical\obstetrics\UltrasoundService;
use App\Models\UltrasoundAdmission;
use Illuminate\Http\Request;

class ObstetricalOverviewController extends Controller
{
    private $ultrasound_admission;

    public function __construct(Request $request)
    {
        $this->ultrasound_admission= new UltrasoundAdmission();
    }

    public function index()
    {
        return view('medical.overviews.index');
    }

    public function ultrasoundIdFromCpnAdmissionId($cpn_admission_id) 
    {
       $admission = CpnAdmission::where('id', $cpn_admission_id)->select('ultrasound_admission_id')->first();
       if ($admission) {
           return $admission->ultrasound_admission_id;
       }
       return "";
    }

    public function pregnancy_card($cpn_admission){


        return [
            'first_checkup',
            'cpn_followup',
            'ultrasound',
            'blood_control'
        ];
    }
}
