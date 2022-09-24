<?php

namespace App\Http\Controllers\V1\patient_system\admission;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\AdmissionRequest;
use App\Models\AdditionalConsultation;
use App\Models\Admission;
use App\Models\InternalReferral;
use App\Service\Medical\obstetrics\CpnAdmissionService;
use App\Service\V1\AdmissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AdmissionController extends Controller
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
        $admission= new AdmissionService();
        return $admission->store($request);
    }
    public function show($id)
    {
        $consultation= Admission::with(['admissionCareDetails'=>function($data){
            return $data->with('activity_price')->get();
        },'patient'=>function($patient){
            return $patient->with('patient_due');
        }])->find($id);
        return $consultation;
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $consultation= new AdmissionService();
        return $consultation->update($request,$id);
    }
    public function destroy($id)
    {
        $consultation= new AdmissionService();
        return $consultation->destroy($id);
    }
    public function list_today(){
        return Admission::whereDate('created_at',Carbon::today())
            ->with(
                [
                    'patient'=>function($patient){
                        return $patient->with('patient_due');
                    },
                     'service_activity',
                    'admissionCareDetails'=>function($data){
                        return $data->with('activity_price')->get();
                    },
                    'admission_type'

                ]
            )->get();
    }
    /**
     * Display a list of the patient depending on the service
     *
     * @return \Illuminate\Http\Response
     */
    public function list_service_date(Request $request){

            return Admission::with('patient','admission_type','admissionCareDetails','service_activity')
                ->where('service_id',$request->service_id)
                ->where('payment_status','PAID')
                ->whereDate('created_at',date($request->date))->get();

    }
    public function list_service_activity_date(Request $request){
        $admission= Admission::with('patient','admission_type','admissionCareDetails','service_activity')
            ->where('payment_status','PAID')
            ->whereDate('created_at',date($request->date));

        if($request->has('service_id')){
           $admission= $admission->where('service_id',$request->service_id);
        }
        if($request->has('service_activity_id')){
//            $admission= $admission->where('service_activity_id',$request->service_activity_id);
            $admission=$admission->where(function ($query) use ( $request) {
                foreach($request->get('service_activity_id') as $id) {
                    $query->orWhere('service_activity_id', $id);
                }
            });
        }

        foreach($result= $admission->get() as $data){
            //check if it is a referral
            if($data->admission_type_id===2){
                // get the "from id in the internal referral table"
                $src_adm_id= InternalReferral::where('to_admission_id',$data->id)->first();
                if($src_adm_id){
                    $src_adm_id=$src_adm_id->from_admission_id;
                    $raw=Admission::with(['category','service','service_activity'])->find($src_adm_id);
                    $data->from_admission=$raw->category['name']."/". $raw->service['name']."/".$raw->service_activity['name'];
                }
            }
            //check if it is additional consultation
            if($data->admission_type_id===3){
                // get the "from id in the internal referral table"
                $src_adm_id= AdditionalConsultation::where('to_admission_id',$data->id)->first();
                if($src_adm_id){
                    $src_adm_id=$src_adm_id->from_admission_id;
                    $raw=Admission::with(['category','service','service_activity'])->find($src_adm_id);
                    $data->from_admission=$raw->category['name']."/". $raw->service['name']."/".$raw->service_activity['name'];
                }
            }
        }
        return $result;

    }

}
