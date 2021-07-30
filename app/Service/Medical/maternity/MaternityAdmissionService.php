<?php


namespace App\Service\Medical\maternity;


use App\Models\MaternityAdmission;

class MaternityAdmissionService
{

    private $admission;
    public function __construct(){
        $this->admission= new MaternityAdmission();
    }

    public function store($request){

        $this->admission->patient_id= $request['patient']['id'];

    }
    public function fill_data($request){
        return [
            'patient_id'=>$request->patient['id'],

        ];
    }
}
