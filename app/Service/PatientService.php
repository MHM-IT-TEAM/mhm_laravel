<?php


namespace App\Service;


use App\Models\EmContact;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientService
{

    private $patientData;
    private $em_data;
    private $avatar;
    private $patId;
    private $nationality;
    public function __construct($request){
        //check if the request has uploaded file
        $this->checkFile($request);
        ///emergency contact data
        $this->em_data= json_decode($request->em_rows);
        $this->nationality=$request->nationality;

        $this->patientData= [
            'firstName'=>strtoupper($request->firstName),
            'lastName'=>ucfirst($request->lastName),
            'gender'=>$request->gender,
            'height'=>$request->height,
            'bloodGroup'=>$request->bloodGroup,
            'birthDate'=>$request->birthDate,
            'martialStatus'=>$request->martialStatus,
            'nationality'=>$this->nationality,
            'job'=>$request->job,
            'cin_no'=>$request->cin_no,
            'cin_date'=>$request->cin_date,
            'cin_place'=>$request->cin_place,
            'education'=>$request->education,
            'adress'=>ucfirst($request->adress),
            'tel'=>$request->tel,
            'email'=>$request->email,
            'mom_name'=>$request->mom_name,
            'dad_name'=>$request->dad_name,
            'avatar'=>$this->avatar
        ];
    }
    /**
     * Store new Patient
     *
     */

    public function store(){
        $patient= new Patient();
        $patient->fill($this->patientData)->save();
        $this->patId= $patient->id;
        $this->storeEmData();
        $this->returnAll();
    }
    /**
     * update a patient;
     */
    public function update($id){
     $patient= Patient::find($id);
     $this->patId=$id;
     //check emContact data
     $validate= $patient->emContacts()->get();
     if(count($validate)>0){
        DB::connection("patSyst")->table('em_contacts')->where('patient_id', $id)->delete();
     }
     $this->storeEmData();
     $patient->fill($this->patientData)->save();

    }
    /**
     * check if the request has fileUpload
     */
    public function checkFile($request){
        if($request->hasFile('avatar')){
            $path= time().'_'.$request->avatar->getClientOriginalName();
            $request->avatar->storeAs('assets/media/images/patients/avatar',$path,'public');
            return $this->avatar= $path;
        }
    }

    /***
     * check if the request has an emergency contact data
     *
     */
    public function storeEmData(){
        if(count($this->em_data)>0){
            foreach ($this->em_data as $data) {
                DB::connection('patSyst')->table('em_contacts')->insert(['tel'=>$data->tel,'name'=>$data->name,'patient_id'=>$this->patId]);
            }
        }
    }
    /***
     * return all records
     */
    public function returnAll(){
        return Patient::all();
    }

}
