<?php

namespace App\Http\Controllers\V1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\patient_system\ExternalReferralRequest;
use App\Models\ExternalReferral;
use App\Models\StorkAdmission;
use App\Models\StorkDiagnose;
use App\Models\StorkDismissal;
use Illuminate\Http\Request;

class StorkExternalReferralController extends Controller
{
    public function update_stork_admission(Request $request){
        //get stork admission_id
        $stork_admission= StorkAdmission::where('admission_id',$request->admission_id)->get()->first();
        //dismiss the patient
        StorkDismissal::create([
            'stork_admission_id'=>$stork_admission->id,
            'dismissal_date'=>$request->departure_date,
            'dismissal_time'=>$request->departure_time,
            'dismissal_diagnosis'=>$request->reason,
            'is_referred'=>1,
            'external_referral_id'=>$request->id
        ]);
        //update_stork admission
        $stork_admission->dismissed=1;
        $stork_admission->save();
    }
}
