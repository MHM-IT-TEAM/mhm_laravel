<?php


namespace App\Service\V1;


use App\Models\Admission;
use App\Models\AdmissionCareDetail;
use App\Models\LunchOrder;
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
//        $data= DB::select('SELECT service_activities.name as service, SUM(patient_cash_flows.paid) as value FROM `admissions`
//                                INNER JOIN service_activities on admissions.service_activity_id=service_activities.id INNER JOIN
//                                patient_cash_flows on admissions.id= patient_cash_flows.admission_id
//                                WHERE DATE(patient_cash_flows.created_at) = CURDATE() GROUP BY service_activities.name');
        $data= DB::select('SELECT categories.name as category, services.name as service, SUM(patient_cash_flows.paid) as value FROM `admissions`
                                INNER JOIN services on admissions.service_id=services.id INNER JOIN
                                patient_cash_flows on admissions.id= patient_cash_flows.admission_id
                                INNER JOIN categories on admissions.category_id= categories.id
                                WHERE DATE(patient_cash_flows.created_at) = CURDATE() GROUP BY categories.name, services.name ORDER BY categories.name');

        return view('cashier/invoices/cash_receipt',compact('data'));
    }

    public static function pay_previous_transaction($request){
//        dd($request->all());
        $cf= PatientCashFlow::find($request->id);
        $cf->paid= $cf->paid +$request->paid;
        $cf->new_debt = $cf->new_debt-$request->paid;
        $cf->save();

        PatientCashFlow::create([
            'patient_id'=>$request->patient_id,
            'admission_id'=>$request->admission_id,
            'to_pay'=>$request->to_pay,
            'paid'=>$request->paid,
            'nature'=>$request->nature

        ]);
    }
    public static function get_patient_category_actual_price_for_activity($activity_price, $patient_category_id) {
        $actual_price = null;
        switch ($patient_category_id){
            case 1:
            case null:
                $actual_price = $activity_price->sector;
                break;
            case 2:
                $actual_price = $activity_price->out_sector;
                break;
            case 3:
                $actual_price = $activity_price->mhm_staff;
                break;
            case 4:
                $actual_price = $activity_price->mhm_staff_family;
                break;
            case 5:
                $actual_price = $activity_price->mhm_partners;
                break;
            case 6:
                $actual_price = $activity_price->vip;
                break;
        }

        return $actual_price;
    }
    public function pay_lunch($request){
        $patient_due= PatientDue::where('patient_id',$request->patient_id)->latest()->first()->amount ?? 0;
        $new_debt=($patient_due+$request->value)-$request->paid;
        PatientCashFlow::create([
            'admission_id'=>$request->admission_id,
            'patient_id'=>$request->patient_id,
            'nature'=>'Lunch payment',
            'last_due'=>$patient_due,
            'to_pay'=>$request->value,
            'paid'=>$request->paid,
            'new_debt'=>$new_debt
        ]);
        $order = LunchOrder::find($request->id);
        $order->status='PAID';
        $order->save();
        $check=PatientDue::where('patient_id',$request->patient_id)->latest()->first();
        if($check){
            $patient_due->update([
                'amount'=>$request->new_debt
            ]);
        }else{
            if($new_debt>0){
                PatientDue::create(
                    [
                        'patient_id'=>$request->patient_id,
                        'amount'=>$new_debt
                    ]
                );
            }
        }

        return response()->json(['success'=>true]);
    }
}
