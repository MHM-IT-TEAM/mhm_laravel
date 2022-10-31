<?php


namespace App\Service\Medical\obstetrics;


use App\Models\Admission;
use App\Models\CpnAdmission;
use App\Models\Patient;
use App\Models\PregnancyHistory;
use App\Models\UltrasoundAdmission;

class CpnAdmissionService
{
    private $admission;
    private $pregHisto;
    public function __construct()
    {
        $this->admission=new CpnAdmission();
        $this->pregHisto=new PregnancyHistory();
    }
    public function store($request){
        $admission = $this->admission->fill($this->fill_data($request));
        $admission->save();
        if(count($request->pregnancy_history)>0){
            foreach($request->pregnancy_history as $preg){
                if($preg['nr_year'] !==''){
                    $this->pregHisto->create($this->pregHistoData($preg,$request->patient_id));
                }
            }
        }
        if($request->has('admission_id')){
            $admission= Admission::find($request->admission_id);
            $admission->status='DONE';
            $admission->save();
        }

        return ["success"=>true,"cpn_admission"=>CpnAdmission::with('patient')->find($this->admission->id)];
    }
    private function fill_data($request){


        return [
            'patient_id'=>$request->patient_id,
            'weight'=>$request->weight,
            'preg_wom_disability'=>$request->preg_wom_disability,
            'preg_wom_chronical_disease'=>$request->preg_wom_chronical_disease,
            'preg_wom_former_illness'=>$request->preg_wom_former_illness,
            'preg_wom_allergie'=>$request->preg_wom_allergie,
            'preg_wom_bleeding'=>$request->preg_wom_bleeding,
            'preg_wom_haematoma'=>$request->preg_wom_haematoma,
            'preg_wom_medication'=>$request->preg_wom_medication,
            'close_family_twins'=>$request->close_family_twins,
            'close_family_oc'=>$request->close_family_oc,
            'close_family_miscarriage'=>$request->close_family_miscarriage,
            'close_family_disease'=>$request->close_family_disease,
            'close_family_malformation'=>$request->close_family_malformation,
            'close_family_prob_in_preg'=>$request->close_family_prob_in_preg,
            'close_family_dead_baby'=>$request->close_family_dead_baby,
            'patient_at_risk'=>$request->patient_at_risk,
            'risk_description'=>$request->risk_description,
            'preeclampsia_needed'=>$request->preeclampsia_needed,
            'high_frequency_prenatal_care'=>$request->high_frequency_prenatal_care,
            'ogtt_needed'=>$request->ogtt_needed,
            'planned_oc'=>$request->planned_oc,
            'planned_oc_date'=>$request->planned_oc_date,
            'planned_induction'=>$request->planned_induction,
            'takes_blood_pressure_medication'=>$request->takes_blood_pressure_medication,
            'blood_pressure_medication_start_date'=>$request->blood_pressure_medication_start_date,
            'dda'=>$request->dda,
            'gravida'=>$request->gravida,
            'parity'=>$request->parity,
            'abortion'=>$request->abortion,
            'miscarriage'=>$request->miscarriage,
            'ev'=>$request->ev,
            'spin'=>$request->spin,
            'christ'=>$request->christ,
            'troch'=>$request->troch,
            'obst'=>$request->obst,
            'michaelis'=>$request->michaelis,
            'baum_hg'=>$request->baum_hg,
            'other_test'=>$request->other_test,
            'other_test_descr'=>$request->other_test_descr,
            'hb'=>$request->hb,
            'problem_for_delivery'=>$request->problem_for_delivery,
            'blood_group'=>$request->blood_group,
            'hiv'=>$request->hiv,
            'syphilis'=>$request->syphilis,
            'responsible'=>$request->responsible,
            'ultrasound_admission_id'=>$request->ultrasound_admission_id,
            'unknown_lpd'=>$request->ultrasound_data['unknown_lpd'],
            'gestational_age'=>$request->ultrasound_data['gestational_age'],
            'edd_method'=>$request->ultrasound_data['edd_method'],
            'edd_ultrasound'=>$request->ultrasound_data['edd_ultrasound'],
            'edd_corrected'=>$request->ultrasound_data['edd_corrected'],

        ];
    }
    private function pregHistoData($preg,$patient_id){
        return [
            'patient_id'=>$patient_id,
            'birth_type'=>$preg['birth_type'],
            'birth_place'=>$preg['birth_place'],
            'birth_problems'=>$preg['problem'],
            'baby_gender'=>$preg['baby_gender'],
            'baby_weight'=>$preg['baby_weight'],
            'infection'=>$preg['infection'],
            'malformation'=>$preg['malformation'],
            'baby_condition'=>$preg['baby_condition'],
            'our_patient'=>$preg['our_patient'],
            'sa'=>$preg['ga'],
            'pueperium'=>$preg['pueperium'],
            'nr_year'=>$preg['nr_year']
        ];
    }
    public function show($reference){
        $admission=  CpnAdmission::find($reference);
        if($admission){
            $pregHisto= PregnancyHistory::where('patient_id',$admission->patient_id)->orderBy('nr_year','desc')->get();
            $ultrasound = UltrasoundAdmission::where('patient_id',$admission->patient_id)->latest()->first();
            return [
                "admission"=>$admission,
                "preg_history"=>$pregHisto,
                "ultrasound"=>$ultrasound,
                "patient"=>Patient::find($admission->patient_id),
                "success"=>true
            ];
        }
        else{
           return response()->json(['message'=>'no data found','success'=>false]);
        }
    }
    public function update($reference, $request){
        $patient= $this->admission->find($reference);
        $patient->fill($this->fill_data($request))->save();
        PregnancyHistory::where('patient_id',$request->patient_id)->delete();
        if(count($request->pregnancy_history)>0){
            foreach($request->pregnancy_history as $preg){
                $this->pregHisto->create($this->pregHistoData($preg,$request->patient_id))->save();
            }
        }
        return ["success"=>true];
    }
}
