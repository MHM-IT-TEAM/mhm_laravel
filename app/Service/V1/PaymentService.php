<?php


namespace App\Service\V1;


use App\Models\Admission;
use App\Models\AdmissionCareDetail;
use App\Models\PatientCashFlow;
use App\Models\PatientDue;
use App\Service\V1\Traits\ServiceResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PaymentService
{
    use ServiceResponseTrait;

    public static function execute_payment($request){
        $details= $request->get('care_details');
        foreach($details as $detail){
           $line= AdmissionCareDetail::find($detail["id"]);
           $line->payment_status=1;
           $line->save();
        }
        PatientCashFlow::create($request->except('care_details'));
        $patient_due= PatientDue::where('patient_id',$request->patient_id)->first();
        if($patient_due){
            $patient_due->update([
                'amount'=>$request->new_debt
            ]);
        }else{
            if($request->new_debt>0){
                PatientDue::create(
                    [
                        'patient_id'=>$request->patient_id,
                        'amount'=>$request->new_debt
                    ]
                );
            }
        }
        $admission= Admission::find($request->admission_id);
        $admission->payment_status='PAID';
        $admission->save();
        return response()->json([
            'success'=>true,
            'msg'=>'Payment successfull'
        ]);
    }
    public static function print_invoice($admission_id){
        $data= Admission::
            with(
                [
                    'patient'=>function($patient){
                        return $patient->with('patient_due');
                    },
                    'service_activity',
                    'admissionCareDetails'=>function($data){
                        return $data->with('activity_price')->where('payment_Status',1)->get();
                    }
                ]
            )
            ->find($admission_id);
        $due=$data['patient'];
        $patient_due=0;
        if($due->patient_due){
            $patient_due=$due->patient_due->amount;
        }
        return view('cashier/invoices/payment')->with(['response'=>$data,'patient_due'=>$patient_due]);
    }
    public static function cash_receipt(){
        $data= DB::select('SELECT service_activities.name as service, SUM(patient_cash_flows.paid) as value FROM `admissions`
                                INNER JOIN service_activities on admissions.service_activity_id=service_activities.id INNER JOIN
                                patient_cash_flows on admissions.id= patient_cash_flows.admission_id
                                WHERE DATE(patient_cash_flows.created_at) = CURDATE() GROUP BY service_activities.name');
        return view('cashier/invoices/cash_receipt',compact('data'));
    }
}
