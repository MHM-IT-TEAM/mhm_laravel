<?php


namespace App\Service\Medical\obstetrics;
use App\Models\Patient;


class SearchService
{
    public function search($request){
        $patient= new Patient();
       if($request !==null) return $patient->search($request)->with(['cpnAdmissions'])->get();
    }
}
