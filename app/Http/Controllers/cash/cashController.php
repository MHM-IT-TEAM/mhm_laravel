<?php
namespace App\Http\Controllers\cash;
use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\PatientCareDetail;
use App\Models\PatientCashFlow;
use App\Models\PatientDue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class cashController extends Controller
{
    public function index(){
        return view('cash.home');
    }
    public function patient_list(){

        $consult= Consultation::with(['patient','typeConsult','patientCareDetails'])->unpaid()->todayConsultation()->get();
        return view('cash.list')->with('consultations',$consult);
    }
    public function pay(Request $request, $consult_id,$patId,$type_consult){

        $cashFlows= PatientCashFlow::where('patient_id',$patId)->get();
        $patient_due= Patient::find($patId)->patient_due()->latest()->get('amount');
        $todayOperations= PatientCareDetail::where('consultation_id',$consult_id)->with('ServicePrices')->get();
        // check if the patient has due amount
        $due= count($patient_due)>0?$patient_due[0]->amount:0;
        $total=0;
        foreach($todayOperations as $todayOp){
            $total+= $todayOp->total;
        }
        //check if the patient has today a transaction
        $paidTodays= DB::connection('patSyst')->table('consultations')
            ->join('patient_cash_flows','consultations.id','=','patient_cash_flows.consultation_id')
            ->where('consultations.patient_id',$patId)
            ->whereDate('consultations.created_at',now())
            ->where('consultations.type_consult_id',$type_consult)->get('patient_cash_flows.paid');
        //
        $paidToday= count($paidTodays)>0?$paidTodays[0]->paid:0;
        $toPay= $total+ $due-$paidToday;
       return view('cash.pay',compact('cashFlows','todayOperations','due','toPay','consult_id','patId'));
    }
    public function finalize_transaction(Request $request){
        //save the transaction data in the patient_cash_flow_table
        $pc= new PatientCashFlow();
        $pc->patient_id= $request->patId;
        $pc->consultation_id= $request->consult_id;
        $pc->last_due= $request->last_dues;
        $pc->value= $request->toPays;
        $pc->paid= $request->paid;
        $pc->due= $request->new_dues;
        $pc->save();
        // if the patient has new due then save it in patient_due table
        $dues= PatientDue::where('patient_id',$request->patId);
        $due= $dues->get('amount');
        if(count($due)>0){
            if ($due[0]->amount > 0) {
                $dues->update([
                    'amount' => $request->new_dues
                ]);
            } else {
                PatientDue::create([
                    'patient_id' => $request->patId,
                    'amount' => $request->new_dues
                ]);
            }
        }else{
            PatientDue::create([
                'patient_id' => $request->patId,
                'amount' => $request->new_dues
            ]);
        }

        // update the payment_status in the consultations table
        $consult= Consultation::find($request->consult_id);
        $consult->update([
            'payment_status'=>'PAID'
        ]);

        return redirect('cash/home/list')->with('status','transaction successful');
    }

    public function details_per_consult($id){
        return PatientCareDetail::consult($id)->with('servicePrices')->get();
    }
    public function finance_rezept(){
        $results= DB::connection('patSyst')->table('consultations')
            ->join ('type_consults','consultations.type_consult_id','=','type_consults.id')
            ->join('patient_cash_flows','consultations.id','=','patient_cash_flows.consultation_id')
            ->selectRaw('SUM(patient_cash_flows.paid) as sum,type_consults.name')
            ->whereDate('consultations.created_at',now())->groupBy('type_consults.name')
            ->get();
        $total=0;
        foreach ($results as $result){
            $total+=$result->sum;
        }
        return view('cash.invoices.finance_rezept')->with(['results'=>$results,'total'=>$total]);
    }
}
