<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\obstetrical;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\patient_system\UltrasoundAdmissionRequest;
use App\Models\Fetus;
use App\Models\UltrasoundAdmission;
use App\Models\UltrasoundDetail;
use App\Service\V1\patient_system\obstetrics\UltrasoundAdmissionService;
use App\Service\V1\patient_system\obstetrics\UltrasoundDetailService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Patient;

class UltrasoundController extends Controller
{

    public function admission(UltrasoundAdmissionRequest $request){
       $admission= new UltrasoundAdmissionService();
       return $admission->store_admission($request->validated());
    }
    public function admission_list($patient_id){
        return UltrasoundAdmission::where('patient_id',$patient_id)->with('fetuses','ultrasoundDetails')->get();
    }
    public function details(Request $request){
        $details= new UltrasoundDetailService();
        return $details->insert_details($request);
    }
    public function patient_search(Request $request){
        $output=[];
        $patient= new Patient();
        $query = $request->get('query');
        $queryWords = explode(' ', $query, 8);
        $patients=$patient->search($queryWords)->get();
        foreach($patients as $pat){
           $output[]=Patient::with(['ultrasoundAdmissions'=>function($admission){
               return $admission->with('fetuses','ultrasoundDetails')->get();
           }])->find($pat->id);
        }
       return response()->json($output);
    }
    public function close_exam($id){
        $admission= UltrasoundAdmission::find($id);
        $admission->status='closed';
        $admission->save();
        return response()->json(['success'=>true]);
    }
    public function get_details($id){
        return UltrasoundAdmission::with('fetuses','ultrasoundDetails')->find($id);
    }
    public function where_patient_id($patient_id){
        return UltrasoundAdmission::where('patient_id',$patient_id)->latest()->first()->id;
    }
}
