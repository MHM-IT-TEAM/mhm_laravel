<?php

namespace App\Http\Controllers\medical\maternity;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaternityAdmissionRequest;
use App\Models\Bed;
use App\Models\CpnAdmission;
use App\Models\MaternityAdmission;
use App\Models\MaternityAdmissionDocument;
use App\Models\Patient;
use App\Service\Medical\maternity\MaternityAdmissionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MaternityAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MaternityAdmission::with(['patient','bed','hospitalServiceDivision'])->get();
    }

    public function create()
    {
        //
    }


    public function store(MaternityAdmissionRequest $request)
    {
        $admission= MaternityAdmission::create($request->validated());
        $bed= Bed::find($request->bed_id);
        $bed->status=1;
        $bed->save();
        return $admission->id;
    }
    public function show($id)
    {
        return MaternityAdmission::with(['maternityAdmissionDocuments','patient','bed','hospitalServiceDivision','maternityActions'])->find($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function last_code(){
        $code=MaternityAdmission::latest()->first();
        if($code){return $code->code;}
        else return ;
    }
    public function fetch_patient_data($id){
        $patient=Patient::with(['cpnAdmissions'=>function($data){
            return $data->latest('created_at')->get();
        }])
            ->with(['ultraSoundAdmissions'=>function($data){
                return $data->latest('created_at')->first();
            }])
            ->find($id);
        $ga='';
        //return the last Gestational age
        if(count($patient->cpnAdmissions)>0){
            $ref=$patient->cpnAdmissions[0]["id"];
            $admission= CpnAdmission::with(['followups'=>function($data){
                return $data->latest('created_at')->first();
            }])->find($ref);
            $ga= $admission->followups[0]["week_of_pregnancy"];//28+2
            $ga_date= $admission->followups[0]["created_at"];//2021/07/14
            $diff_in_days=Carbon::now()->floatDiffInWeeks(Carbon::parse($ga_date));
            $int_value=floor($diff_in_days);//1
            $decimal= (($diff_in_days-$int_value)*6); // question: why is this *6 ? 5.4
            $split= explode('+',$ga);//28,2
            $ga=$this->calculate($int_value,$split[0],$decimal,$split[1]);
        }

        return response()->json([
            "ga"=>$ga,
            "patient_data"=>$patient
        ]);
    }
    private function calculate($whole,$whole1,$part0,$part1){
        $part= $whole+$whole1;//1+28=29
        $dec=$part0+$part1;//5.4+2=7.4
        if($dec>6){
            $part=$part+1;//30
            $dec=round($dec/6);
        };
        return $part."+".round($dec);
    }
    public function upload_files(Request $request){
        foreach($request->file()as $file){
            $path= $file->store('assets/media/images/maternity/admission');
            MaternityAdmissionDocument::create(
              [
                  'maternity_admission_id'=>$request->maternity_admission_id,
                  'document_path'=>$path
              ]
            );
        }
    }

}
