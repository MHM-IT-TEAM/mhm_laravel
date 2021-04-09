<?php


namespace App\Service;


use App\Models\CpnAdmission;
use App\Models\PregnancyHistory;

class CpnAdmissionService
{
    public function store($request){
        $admission = new CpnAdmission();
        $pregHisto= new PregnancyHistory();
        if(count($request->pregnancy_history)>1){
            foreach($request->pregnancy_history as $preg){
                $pregHisto->create([
                    'patient_id'=>$request->patient_id,
                    'pregnancy'=>$preg['pregnancy'],
                    'birth_type'=>$preg['birth_type'],
                    'birth_place'=>$preg['birth_place'],
                    'birth_problems'=>$preg['birth_problems'],
                    'newBorn'=>$preg['newBorn'],
                    'pueperium'=>$preg['pueperium'],
                    'nr_year'=>$preg['nr_year']
                ]);
            }
        }
        $admission->create([
            'patient_id'=>$request->patient_id,
            'ddr'=>$request->ddr,
            'dpa'=>$request->dpa,
            'dpa_method'=>$request->dpa_method,
            'gravida'=>$request->gravida,
            'parity'=>$request->parity,
            'abortion'=>$request->abortion,
            'miscarriage'=>$request->miscarriage,
            'ev'=>$request->ev,
            'problems_with_last_delivery'=>$request->problems_with_last_delivery,
            'spin'=>$request->spin,
            'christ'=>$request->christ,
            'michaelis'=>$request->michaelis,
            'baum_hg'=>$request->baum_hg,
            'other_test'=>$request->other_test,
            'hb'=>$request->hb,
            'problem_for_delivery'=>$request->problem_for_delivery,
            'blood_group'=>$request->blood_group,
            'hiv'=>$request->hiv,
            'syphilis'=>$request->syphilis,
            'twins'=>$request->twins,
            'oc'=>$request->oc,
            'close_family'=>$request->close_family,
            'pregnant_woman'=>$request->pregnant_woman

        ]);
    }
}
