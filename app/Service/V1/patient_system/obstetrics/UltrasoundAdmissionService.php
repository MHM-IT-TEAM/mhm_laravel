<?php


namespace App\Service\V1\patient_system\obstetrics;


use App\Models\ActivityPrice;
use App\Models\Admission;
use App\Models\Fetus;
use App\Models\Patient;
use App\Models\UltrasoundAdmission;
use App\Service\V1\AdmissionService;
use App\Service\V1\PaymentService;
use Carbon\Carbon;

class UltrasoundAdmissionService
{
    public function store_admission($request){
        //Insert into the admission table
        $ultrasound_admission= UltrasoundAdmission::create($request);
        $request=collect($request);
        if($request->get('is_patient_pregnant')===1){
            for($i=0;$i<$request->get('count_of_fetus');$i++){
                Fetus::create(["ultrasound_admission_id"=>$ultrasound_admission->id]);
            }
            // If The ultrasound ist positive then create new admission for the (CPN)
            $this->create_first_prenatal_checkup_admission($request->get('admission_id'),$request->get('patient_id'),$ultrasound_admission->id);
        }
        return response()->json(['success'=>true]);
    }
    private function create_first_prenatal_checkup_admission($admission_id,$patient_id,$ultrasound_admission_id) {
        $admission = Admission::find($admission_id);
        $patient = Patient::find($patient_id);
        list($activity_price_id, $activity_price) = $this->get_new_admission_activity_price($ultrasound_admission_id,$patient->patient_category_id);

        $admission_service = new AdmissionService();
        return $admission_service->store_internal((object)[
            'patient_id'=>$patient_id,
            'category_id'=>6, // outpatient
            'service_id'=>8, // outpatient obstetrics
            'service_activity_id'=>12, // first cpn
            'mhm_partner_id'=>$admission->mhm_partner_id,
            'user_id'=>$admission->user_id,
            'admission_priority_id'=>$admission->admission_priority_id,
            'status'=>'RUNNING',
            'pharmacy_status'=>null,
            'payment_status'=>null,
            'provisional_status'=>$admission->provisional_diagnosis,
            'temp'=>$admission->temp,
            'weight'=>$admission->weight,
            'taSysto'=>$admission->taSysto,
            'taDia'=>$admission->taDia,
            'pulse'=>$admission->pulse,
            'spo2'=>$admission->spo2,
            'remark'=>$admission->remark,
            'admission_care_details'=> [
                'id'=>$activity_price_id,
                'price'=>$activity_price
            ]
        ]);
    }
    private function get_new_admission_activity_price($ref, $patient_category) {
        list(, , , $ga_in_days) = $this->get_edd_info_and_gestational_age_at_date($ref, Carbon::today());
        $twelve_weeks = 7 * 12;
        $twenty_weeks = 7 * 20;
        if ($ga_in_days < $twelve_weeks)
            $activity_price = ActivityPrice::find(16);
        else if ($ga_in_days < $twenty_weeks)
            $activity_price = ActivityPrice::find(17);
        else
            $activity_price = ActivityPrice::find(18);

        $actual_price = PaymentService::get_patient_category_actual_price_for_activity($activity_price, $patient_category);

        return array($activity_price->id, $actual_price);
    }
    /**
     * Get EDD info and gestational age at provided date
     * @param Carbon $date
     * @return [edd,edd_method,gestational_age,gestational_age_in_days]
     */
    public function get_edd_info_and_gestational_age_at_date($ref, $date) {
        $edd='';
        $admission= UltrasoundAdmission::find($ref);
        $edd_method = $admission->edd_method;

        switch ($edd_method) {
            case 'calc':
                // calc is only stored on the first or early screening
                $edd = $admission->edd_calculated;
                break;
            case 'echo':
                $edd = $admission->edd_ultrasound;
                break;
            case 'corrected':
                $edd = $admission->edd_corrected;
                break;
        }
        $edd = Carbon::parse($edd);
        $diff_in_days = $edd->diffInDays($date);

        $ga_in_days = (40*7) - $diff_in_days;

        $ga_weeks = floor($ga_in_days / 7);
        $ga_days = $ga_in_days % 7;

        $ga = $ga_weeks . "+" . $ga_days;

        return array($edd, $edd_method, $ga, $ga_in_days);
    }

}
