<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\obstetrical;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\UltrasoundAdmission;
use App\Service\Medical\obstetrics\CpnAdmissionService;
use App\Models\CpnAdmission;
use App\Service\Medical\obstetrics\SearchService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CpnAdmissionController extends Controller
{
    private $admission;

    public function __construct()
    {
        $this->admission = new CpnAdmissionService();
    }

    public function index(){
        return view('medical.obstetrics.home');
    }
    public function store(Request $request){
        return $this->admission->store($request);
    }

    public function show($reference){
        return $this->admission->show($reference);
    }
    public function update($reference,Request $request){
        return $this->admission->update($reference,$request);
    }
    public function search (Request $request){
        $search= new SearchService();
        return $search->search($request->search);
    }
    public function get_ultrasound_admission_data($patient_id){
        return UltrasoundAdmission::where('patient_id',$patient_id)->latest()->first();
    }
    public function patient_cpn_search(Request $request){
        $output=[];
        $patient= new Patient();
        $query = $request->get('query');
        $queryWords = explode(' ', $query, 8);
        $patients=$patient->search($queryWords)->get();
        foreach($patients as $pat){
            $output[]=Patient::with(['cpnAdmissions'=>function($admission){
                return $admission->with('followups')->get();
            }])->find($pat->id);
        }
        return response()->json($output);
    }
}
