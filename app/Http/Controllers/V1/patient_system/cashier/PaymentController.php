<?php

namespace App\Http\Controllers\V1\patient_system\cashier;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Patient;
use App\Models\PatientCashFlow;
use App\Service\V1\PaymentService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function unpaid_today(){
        return Admission::whereDate('created_at',Carbon::today())
            ->with(
                [
                    'patient'=>function($patient){
                        return $patient->with('patient_due');
                    },
                    'service_activity',
                    'admissionCareDetails'=>function($data){
                        return $data->with('activity_price')->get();
                    }
                ]
            )->whereNull('payment_status')
            ->get();
    }
    public function pay(Request $request){
        return PaymentService::execute_payment($request);
    }
    public function print_invoice($admission_id){
        return PaymentService::print_invoice($admission_id);
    }
    public function former_transaction_list($patient_id){
       return PatientCashFlow::with([
           'admission'=>function($admission){
                return $admission->with('service_activity')->get();
           }
       ])->where('patient_id',$patient_id)->get();
    }
    public function cash_receipt(){
        return PaymentService::cash_receipt();
    }
    public function pay_previous_transaction(Request $request){
        return PaymentService::pay_previous_transaction($request);
    }
    public function patient_due($patient_id){
        return PatientCashFlow::where('patient_id',$patient_id)->latest('created_at')->first()->new_debt ?? 0;
    }
}
