<?php


namespace App\Service\Medical\obstetrics;
use App\Models\Patient;


class SearchService
{
    public function search($request){
        if (!$request)
            return [];

        $patient = new Patient();
        
        $data = $patient
            ->search(explode(' ', $request), 8)
            ->with(['cpnAdmissions:id,created_at,patient_id','cpnAdmissions.followups:id,created_at,cpn_admission_id','ultraSoundAdmissions:id,created_at,patient_id'])
            ->get();

        return $data;
    }
}
