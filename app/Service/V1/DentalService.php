<?php


namespace App\Service\V1;


use App\Models\Admission;
use App\Models\AdmissionCareDetail;
use App\Models\DentalCheckup;
use App\Models\DentalTreatment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Service\V1\Traits\GraceCsbTransactionTrait;

class DentalService
{
    use GraceCsbTransactionTrait;
    public function send_to_cashier($request){
        DentalTreatment::save_todo_for_today($request->details,$request->admission['id'],$request->admission['patient_id']);
        //update the satus of admission to "DONE"
        $current_admission=Admission::find($request->admission['id']);
        $current_admission->status='DONE';
        $current_admission->save();
        //create a new admission
        $admission= new Admission();
        $admission->patient_id= $request->admission['patient_id'];
        $admission->category_id=$request->admission['category_id'];
        $admission->service_id=$request->admission['service_id'];
        $admission->service_activity_id=$request->admission['service_activity_id'];
        $admission->admission_priority_id=$request->admission['admission_priority_id'];
        $admission->user_id=$request->admission['user_id'];
        $admission->admission_type_id=$request->admission['admission_type_id'];
        $admission->status=$request->admission['status'];
        $admission->save();
        //create the care details
        //care
        $this->_split_details($admission->id,'care',$request);
        //extraction
        $this->_split_details($admission->id,'extraction',$request);
        //followup
        $this->_split_details($admission->id,'followup_care',$request);
        //cleaning
        $this->_split_details($admission->id,'Cleaning',$request);
        return response()->json(['success'=>true]);
    }
    private function _split_details($admission_id,$type,$request){
        if(count($request->details[$type])>0){
            AdmissionCareDetail::create([
                'admission_id'=>$admission_id,
                'activity_price_id'=>$request->price_list[$type]['id'],
                'qty'=>count($request->details[$type]),
                'total'=>$request->prices[$type],
                'payment_status'=>0
            ]);
        }

    }
    public function store(Request $request){
        $diag= collect($request->diagnostic);
        $checkup = new DentalCheckup();
        foreach($diag as $item){
            if(!empty($item)){
                foreach($item as $det){
                    $checkup[$det['id']]=$det['diagnostic']['symbol'];
                }
            }
        }
        $checkup->admission_id=$request->admission['id'];
        $checkup->patient_id=$request->admission['patient_id'];
        $checkup->save();
        return response()->json(['success'=>true]);
    }
    public function update($request, $id)
    {
        //update the dental checkup table
        $checkup = DentalCheckup::find($id);
        $diag = collect($request->diagnostic);
        foreach ($diag as $item) {
            if (!empty($item)) {
                foreach ($item as $det) {
                    $symbol = '';
                    if ($det['diagnostic']['symbol'] === 'EX') $symbol = 'X';
                    if ($det['diagnostic']['symbol'] === 'C') $symbol = 'FC';
                    $checkup[$det['id']] = $symbol;
                }
            }
        }
        $checkup->save();
        // if there are medications data
        if (count($request->medication) > 0) {
            $this->transaction($request->medication, $request->admission['id']);
        }
        //update the dental treatment table
        DentalTreatment::whereDate('created_at', Carbon::today())
            ->where('patient_id', $request->admission['patient_id'])
            ->update([
                'remark' => $request->remark
            ]);

        //update the admission table
        $admission= Admission::find($request->admission['id']);
        $admission->status='DONE';
        $admission->save();
        //if all good return success response
        return response()->json(['success'=>true]);
    }

}
