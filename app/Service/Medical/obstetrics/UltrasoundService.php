<?php


namespace App\Service\Medical\obstetrics;

use App\Http\Controllers\v1\patient_system\consultation\ServicePriceController;
use App\Models\ActivityPrice;
use App\Models\UltrasoundAdmission;
use App\Models\UltrasoundFirstScreening;
use App\Models\UltrasoundSecondScreening;
use App\Models\UltrasoundThirdScreening;
use App\Models\UltrasoundConfirmationOfDueDateScreening;
use App\Models\UltrasoundEarlyScreening;
use App\Models\UltrasoundAdditionalScreening;
use App\Service\V1\AdmissionService;
use App\Models\Admission;
use App\Models\Patient;
use App\Service\V1\PaymentService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UltrasoundService
{
    private $early_screening;
    private $first_screening = [];
    private $confirmation_of_due_date_screening;
    private $second_screening;
    private $third_screening;
    private $additional_screening;
    private $screening;
    private $patient_id;
    private $twin;
    private $admission_id;
    private $response=['msg'=>''];


    public function set($request)
    {
        $this->screening = explode(',', $request->screening);
        $this->patient_id = $request->patient_id;
        $this->twin = $request->count_of_fetus;
        $this->admission_id = $request->admission_id;
        foreach ($request->formData as $data) {
            if (array_key_exists('early_screening', $data)) {
                $this->early_screening[]= $data['early_screening'];
            }
            $this->first_screening[] = $data['first_screening'];

            if (array_key_exists('confirmation_of_due_date_screening', $data)) {
                $this->confirmation_of_due_date_screening[]= $data['confirmation_of_due_date_screening'];
            }

            $this->second_screening[] = $data['second_screening'];
            $this->third_screening[] = $data['third_screening'];

            if (array_key_exists('additional_screening', $data)) {
                $this->additional_screening[] = $data['additional_screening'];
            }
        };
    }

    public function store($request)
    {
        if (!$request->is_patient_pregnant) {
            return $this->store_patient_not_pregnant($request);
        }

        $is_new_admission = false;
        /**the created at field ist required to continue the process**/
        $this->set($request);
        if ($request->ref === null) {
            $is_new_admission = true;

            $admission = new UltrasoundAdmission();
            $admission->patient_id = $this->patient_id;
            $admission->twin_pregnancy = $this->twin;
            $admission->admission_id = $this->admission_id;
            $admission->is_patient_pregnant = true;
            $admission->save();
            $ref = $admission->id;

            $this->response=['msg'=>'Reference:'.$ref];
        }else{
            $ref=$request->ref;
            $this->response=['msg'=>'Data Updated'];
        }

        /** check each screening elements whether they are new or update */
        if (in_array('early', $this->screening)) {
            foreach($this->early_screening as $row) {
                if ($row['status'] === 'new') {
                    $this->fill_early_screening($row, $ref,'new');
                }
                elseif ($row['status'] == 'update') {
                    $this->fill_early_screening($row, $ref,'update');
                }
            }
        }

        if (in_array('1', $this->screening)) {
            foreach($this->first_screening as $row) {
                foreach ($row as $fs) {
                    if ($fs['status'] === 'new') {
                        $this->fill_first_screening($fs, $ref,'new');
                    }
                    elseif ($fs['status'] == 'update') {
                        $this->fill_first_screening($fs, $ref,'update');
                    }
                }
            }
        }

        if (in_array('cdd', $this->screening)) {
            foreach($this->confirmation_of_due_date_screening as $row) {
                if ($row['status'] === 'new') {
                    $this->fill_confirmation_of_due_date_screening($row, $ref,'new');
                }
                elseif ($row['status'] == 'update') {
                    $this->fill_confirmation_of_due_date_screening($row, $ref,'update');
                }
            }
        }

        if (in_array('2', $this->screening)) {
            foreach($this->second_screening as $row_1){
                foreach($row_1 as $ss){
                    if($ss['status']==='new'){
                        $this->fill_second_screening($ss, $ref,'new');
                    }
                    elseif($ss['status']=='update'){
                        $this->fill_second_screening($ss, $ref,'update');
                    }
                }
            }
        }

        if (in_array('3', $this->screening)) {
            foreach($this->third_screening as $row_2){
                foreach($row_2 as $ts){
                    if($ts['status']==='new'){
                        $this->fill_third_screening($ts, $ref,'new');
                    }
                    elseif($ts['status']=='update'){
                        $this->fill_third_screening($ts, $ref,'update');
                    }
                }
            }
        }

        if (in_array('additional', $this->screening)) {
            foreach($this->additional_screening as $row){
                foreach($row as $s){
                    if($s['status']==='new'){
                        $this->fill_additional_screening($s, $ref,'new');
                    }
                    elseif($s['status']=='update'){
                        $this->fill_additional_screening($s, $ref,'update');
                    }
                }
            }
        }

        $admission = UltrasoundAdmission::find($ref);

        if ($is_new_admission) {
            $new_admission_id = $this->create_first_prenatal_checkup_admission($ref);

            $admission->admission_id_for_first_cpn = $new_admission_id;
        }

        $admission->updated_at = Carbon::now();
        $admission->save();

        $this->set_admission_done($request);

        return $this->response;
    }

    private function store_patient_not_pregnant($request) {
        if ($request->ref === null) {
            $admission = new UltrasoundAdmission();
            $admission->patient_id = $request->patient_id;
            $admission->admission_id = $request->admission_id;
            $admission->twin_pregnancy = 0;
            $admission->is_patient_pregnant = false;
            $admission->remark=$request->remark_when_ultrasound_neg;
            $admission->save();
            $ref = $admission->id;

            $this->response=['msg'=>'Reference:'.$ref];
        }else{
            $ref=$request->ref;
            $this->response=['msg'=>'Data Updated'];
        }

        $this->set_admission_done($request);

        return $this->response;
    }

    private function set_admission_done($request) {
        if($request->admission_id){
            $admission = Admission::find($request->admission_id);
            $admission->status='DONE';
            $admission->save();
        }
    }

    private function create_first_prenatal_checkup_admission($ref) {
        $admission = Admission::find($this->admission_id);
        $patient = Patient::find($this->patient_id);

        list($activity_price_id, $activity_price) = $this->get_new_admission_activity_price($ref,$patient->patient_category_id);

        $admission_service = new AdmissionService();
        return $admission_service->store_internal((object)[
            'patient_id'=>$this->patient_id,
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

        $activity_price = null;

        if ($ga_in_days < $twelve_weeks)
            $activity_price = ActivityPrice::find(16);
        else if ($ga_in_days < $twenty_weeks)
            $activity_price = ActivityPrice::find(17);
        else
            $activity_price = ActivityPrice::find(18);

        $actual_price = PaymentService::get_patient_category_actual_price_for_activity($activity_price, $patient_category);

        return array($activity_price->id, $actual_price);
    }

    public function fetch($id) {
        $search= UltrasoundAdmission::with(['ultrasound_early_screenings','ultrasound_first_screenings','ultrasound_confirmation_of_due_date_screenings','ultrasound_second_screenings','ultrasound_third_screenings','ultrasound_additional_screenings'])->find($id);
        $patient_id= $search->patient_id;
        $count= $search->twin_pregnancy;
        $early=$search->ultrasound_early_screenings;
        $first=$search->ultrasound_first_screenings->groupBy('fetus');
        $cdd=$search->ultrasound_confirmation_of_due_date_screenings;
        $second=$search->ultrasound_second_screenings->groupBy('fetus');
        $third=$search->ultrasound_third_screenings->groupBy('fetus');
        $additional = $search->ultrasound_additional_screenings->groupBy('fetus');

        $output=[
            'count'=>$count,
            'early'=>$early,
            'first'=>$first,
            'confirmation_of_due_date'=>$cdd,
            'second'=>$second,
            'third'=>$third,
            'additional'=>$additional,
            'patient_id'=>$patient_id,
            'admission_id'=>$search->admission_id,
            'is_patient_pregnant'=>$search->is_patient_pregnant
        ];

        return $output;
    }

    public function show($id){
        $output = $this->fetch($id);

        return response()->json($output);
    }

    private function isoToDateFormat($isoDate) {
        if (!$isoDate)
            return null;

        return Carbon::parse($isoDate)->format('Y-m-d');
    }

    private function fill_early_screening($data,$ref,$status=null){
        if($status==='new'){
            $screen= new UltrasoundEarlyScreening();
        }else{
            $screen= UltrasoundEarlyScreening::find($data['id']);
        }

            $screen->ultrasound_admission_id= $ref;
            $screen->unknown_lpd = $data['unknown_lpd'];
            $screen->ddr = $this->isoToDateFormat($data['ddr']);
            $screen->edd_calculated= $this->isoToDateFormat($data['edd_calculated']);
            $screen->edd_ultrasound= $this->isoToDateFormat($data['edd_ultrasound']);
            $screen->edd_corrected= $this->isoToDateFormat($data['edd_corrected']);
            $screen->gestational_age = $data['gestational_age'];
            $screen->edd_method = $data['edd_method'];
            $screen->intrauterine= $data['intrauterine'];
            $screen->heartbeat= $data['heartbeat'];
            $screen->embryo_visible= $data['embryo_visible'];
            $screen->remark= $data['remark'];
            $screen->other= $data['other'];
            $screen->hc= $data['hc'];
            $screen->ac= $data['ac'];
            $screen->fl= $data['fl'];
            $screen->gs= $data['gs'];
            $screen->crl= $data['crl'];
            $screen->fhr= $data['fhr'];
            $screen->ewb= $data['ewb'];
            $screen->bpd= $data['bpd'];
            $screen->fetus=$data['fetus'];
            $screen->responsible=$data['responsible'];
            $medical_staff="";
            if(count($data['medical_staff'])>0){
                foreach($data['medical_staff'] as $staff){
                    $medical_staff.=$staff.",";
                }
                $medical_staff=rtrim($medical_staff,',');
            }
            $screen->medical_staff= $medical_staff;
            $screen->save();

    }
    private function fill_first_screening($data,$ref,$status=null){
        if($status==='new'){
            $first_screen= new UltrasoundFirstScreening();
        }else{
            $first_screen= UltrasoundFirstScreening::find($data['id']);
        }

            $first_screen->ultrasound_admission_id= $ref;
            $first_screen->unknown_lpd = $data['unknown_lpd'];
            $first_screen->ddr = $this->isoToDateFormat($data['ddr']);
            $first_screen->edd_calculated= $this->isoToDateFormat($data['edd_calculated']);
            $first_screen->edd_ultrasound= $this->isoToDateFormat($data['edd_ultrasound']);
            $first_screen->edd_corrected= $this->isoToDateFormat($data['edd_corrected']);
            $first_screen->gestational_age = $data['gestational_age'];
            $first_screen->edd_method = $data['edd_method'];
            $first_screen->intrauterine= $data['intrauterine'];
            $first_screen->heartbeat= $data['heartbeat'];
            $first_screen->embryo_visible= $data['embryo_visible'];
            $first_screen->remark= $data['remark'];
            $first_screen->other= $data['other'];
            $first_screen->hc= $data['hc'];
            $first_screen->ac= $data['ac'];
            $first_screen->fl= $data['fl'];
            $first_screen->gs= $data['gs'];
            $first_screen->crl= $data['crl'];
            $first_screen->fhr= $data['fhr'];
            $first_screen->ewb= $data['ewb'];
            $first_screen->bpd= $data['bpd'];
            $first_screen->fetus=$data['fetus'];
            $first_screen->responsible=$data['responsible'];
            $medical_staff="";
            if(count($data['medical_staff'])>0){
                foreach($data['medical_staff'] as $staff){
                    $medical_staff.=$staff.",";
                }
                $medical_staff=rtrim($medical_staff,',');
            }
            $first_screen->medical_staff= $medical_staff;
            $first_screen->save();

    }
    private function fill_confirmation_of_due_date_screening($data,$ref,$status=null){
        if($status==='new'){
            $screen= new UltrasoundConfirmationOfDueDateScreening();
        }else{
            $screen= UltrasoundConfirmationOfDueDateScreening::find($data['id']);
        }

            $screen->ultrasound_admission_id = $ref;
            $screen->edd_ultrasound= $this->isoToDateFormat($data['edd_ultrasound']);
            $screen->edd_corrected= $this->isoToDateFormat($data['edd_corrected']);
            $screen->edd_method = $data['edd_method'];
            $screen->gestational_age = $data['gestational_age'];
            $screen->hc= $data['hc'];
            $screen->ac= $data['ac'];
            $screen->fl= $data['fl'];
            $screen->gs= $data['gs'];
            $screen->crl= $data['crl'];
            $screen->fhr= $data['fhr'];
            $screen->ewb= $data['ewb'];
            $screen->bpd= $data['bpd'];
            $screen->fetus = $data['fetus'];
            $screen->remark = $data['remark'];
            $screen->other = $data['other'];
            $screen->responsible=$data['responsible'];
            $medical_staff="";
            if(count($data['medical_staff'])>0){
                foreach($data['medical_staff'] as $staff){
                    $medical_staff.=$staff.",";
                }
                $medical_staff=rtrim($medical_staff,',');
            }
            $screen->medical_staff= $medical_staff;
            $screen->save();
    }
    private function fill_second_screening($data,$ref,$status=null){

        if($status==='new'){
            $second_screen= new UltrasoundSecondScreening();
        }else{
            $second_screen= UltrasoundSecondScreening::find($data['id']);
        }
            $second_screen->ultrasound_admission_id= $ref;
            $second_screen->edd_ultrasound= $this->isoToDateFormat($data['edd_ultrasound']);
            $second_screen->gestational_age = $data['gestational_age'];
            $second_screen->position_of_baby= $data['position_of_baby'];
            $second_screen->presentation_of_baby= $data['presentation_of_baby'];
            $second_screen->placenta_type= $data['placenta_type'];
            $second_screen->normal_growth= $data['normal_growth'];
            $second_screen->normal_amniotic_fluid= $data['normal_amniotic_fluid'];
            $second_screen->suspicion_for_malformation= $data['suspicion_for_malformation'];
            $second_screen->malformation_explanation= $data['malformation_explanation'];
            $second_screen->remark= $data['remark'];
            $second_screen->heartbeat= $data['heartbeat'];
            $second_screen->other= $data['other'];
            $second_screen->hc= $data['hc'];
            $second_screen->ac= $data['ac'];
            $second_screen->fl= $data['fl'];
            $second_screen->gs= $data['gs'];
            $second_screen->crl= $data['crl'];
            $second_screen->fhr= $data['fhr'];
            $second_screen->bpd= $data['bpd'];
            $second_screen->ewb= $data['ewb'];
            $second_screen->fetus= $data['fetus'];
            $second_screen->responsible=$data['responsible'];
            $medical_staff='';
            if(count($data['medical_staff'])>0){
                foreach($data['medical_staff'] as $staff){
                    $medical_staff.=$staff.",";
                }
                $medical_staff=rtrim($medical_staff,',');
            }
            $second_screen->medical_staff= $medical_staff;

            $second_screen->save();

    }
    private function fill_third_screening($data,$ref,$status=null){
        if($status=='new'){
            $third_screen= new UltrasoundThirdScreening();
        }else{
            $third_screen= UltrasoundThirdScreening::find($data['id']);
        }
            $third_screen->ultrasound_admission_id= $ref;
            $third_screen->edd_ultrasound= $this->isoToDateFormat($data['edd_ultrasound']);
            $third_screen->gestational_age = $data['gestational_age'];
            $third_screen->placenta_type= $data['placenta_type'];
            $third_screen->normal_birth= $data['normal_birth'];
            $third_screen->normal_growth= $data['normal_growth'];
            $third_screen->amniotic_liquid= $data['amniotic_liquid'];
            $third_screen->single_pocket= $data['single_pocket'];
            $third_screen->wop_equality= $data['wop_equality'];
            $third_screen->hc= $data['hc'];
            $third_screen->ac= $data['ac'];
            $third_screen->fl= $data['fl'];
            $third_screen->gs= $data['gs'];
            $third_screen->crl= $data['crl'];
            $third_screen->fhr= $data['fhr'];
            $third_screen->other= $data['other'];
            $third_screen->remark= $data['remark'];
            $third_screen->ewb= $data['ewb'];
            $third_screen->bpd= $data['bpd'];
            $third_screen->fetus= $data['fetus'];
            $third_screen->responsible=$data['responsible'];

            $medical_staff='';
            if(count($data['medical_staff'])>0){
                foreach($data['medical_staff'] as $staff){
                    $medical_staff.=$staff.",";
                }
                $medical_staff=rtrim($medical_staff,',');
            }
            $third_screen->medical_staff= $medical_staff;
            $third_screen->save();

    }
    private function fill_additional_screening($data,$ref,$status=null){
        if($status=='new'){
            $screen= new UltrasoundAdditionalScreening();
        }else{
            $screen= UltrasoundAdditionalScreening::find($data['id']);
        }
            $screen->ultrasound_admission_id= $ref;
            $screen->reason_id = $data['reason_id'];
            $screen->reason_explanation = $data['reason_explanation'];
            $screen->fetus= $data['fetus'];
            $screen->edd_ultrasound= $this->isoToDateFormat($data['edd_ultrasound']);
            $screen->gestational_age = $data['gestational_age'];
            $screen->heartbeat= $data['heartbeat'];
            $screen->normal_growth= $data['normal_growth'];
            $screen->placenta_type= $data['placenta_type'];
            $screen->normal_amniotic_fluid= $data['normal_amniotic_fluid'];
            $screen->position_of_baby= $data['position_of_baby'];
            $screen->presentation_of_baby= $data['presentation_of_baby'];
            $screen->suspicion_for_malformation= $data['suspicion_for_malformation'];
            $screen->malformation_explanation= $data['malformation_explanation'];
            $screen->normal_birth= $data['normal_birth'];
            $screen->amniotic_liquid= $data['amniotic_liquid'];
            $screen->single_pocket= $data['single_pocket'];
            $screen->wop_equality= $data['wop_equality'];
            $screen->hc= $data['hc'];
            $screen->ac= $data['ac'];
            $screen->fl= $data['fl'];
            $screen->gs= $data['gs'];
            $screen->crl= $data['crl'];
            $screen->fhr= $data['fhr'];
            $screen->ewb= $data['ewb'];
            $screen->bpd= $data['bpd'];
            $screen->other= $data['other'];
            $screen->remark= $data['remark'];

            $screen->responsible=$data['responsible'];

            $medical_staff='';
            if(count($data['medical_staff'])>0){
                foreach($data['medical_staff'] as $staff){
                    $medical_staff.=$staff.",";
                }
                $medical_staff=rtrim($medical_staff,',');
            }
            $screen->medical_staff= $medical_staff;
            $screen->save();
    }

    /**
     * Get EDD info and gestational age at provided date
     * @param Carbon $date
     * @return [edd,edd_method,gestational_age,gestational_age_in_days]
     */
    public function get_edd_info_and_gestational_age_at_date($ref, $date) {
        $ga='';
        $edd='';
        $edd_method='';

        $admission= UltrasoundAdmission::with(['ultrasound_early_screenings','ultrasound_first_screenings','ultrasound_confirmation_of_due_date_screenings'])
            ->find($ref);

        $first_screening = null;
        $screening = null;

        if (count($admission->ultrasound_first_screenings) > 0) {
            $first_screening = end($admission->ultrasound_first_screenings)[0];
        }
        else if (count($admission->ultrasound_early_screenings) > 0) {
            $first_screening = end($admission->ultrasound_early_screenings)[0];
        }

        if(count($admission->ultrasound_confirmation_of_due_date_screenings) > 0) {
            $screening = $admission->ultrasound_confirmation_of_due_date_screenings[0];
        }
        elseif (count($admission->ultrasound_first_screenings) > 0) {
            $screening = $first_screening;
        }
        else if (count($admission->ultrasound_early_screenings) > 0) {
            $screening = $first_screening;
        }

        $edd_method = $screening->edd_method;

        switch ($edd_method) {
            case 'calc':
                // calc is only stored on the first or early screening
                $edd = $first_screening->edd_calculated;
                break;
            case 'echo':
                $edd = $screening->edd_ultrasound;
                break;
            case 'corrected':
                $edd = $screening->edd_corrected;
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

    public function get_pregnancy_followup_information($ultrasound_admission_id, $admission_id_for_first_cpn) {
        list($edd, $edd_method, $ga, $ga_in_days) = $this->get_edd_info_and_gestational_age_at_date($ultrasound_admission_id, Carbon::now());

        $admission_for_first_cpn = Admission::with(['patient',
            'admissionCareDetails'=>function($data){
                return $data->with('activity_price')->get();
            }])
            ->find($admission_id_for_first_cpn);
        $patient = $admission_for_first_cpn->patient;

        $first_cpn_activity_price = $admission_for_first_cpn->admissionCareDetails[0]->activity_price;

        $followup_first_stage_upper_bound = 224; // 32+0 in days
        $number_of_second_stage_followups = 4; // followups every 2 weeks from end of first stage to EDD

        // Followup every 4 weeks (=28 days) in first stage
        $number_of_first_stage_followups = floor(($followup_first_stage_upper_bound - $ga_in_days) / 28);
        $number_of_followups = $number_of_first_stage_followups + $number_of_second_stage_followups;

        $first_cpn_price = PaymentService::get_patient_category_actual_price_for_activity($first_cpn_activity_price, $patient->patient_category_id);
        $followup_price = round($first_cpn_price / $number_of_followups, -2);

        $total = $first_cpn_price;

        return array($edd, $followup_price, $total, $number_of_followups);
    }
}
