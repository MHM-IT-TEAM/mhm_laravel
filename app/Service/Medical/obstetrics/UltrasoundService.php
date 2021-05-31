<?php


namespace App\Service\Medical\obstetrics;


use App\Models\UltrasoundAdmission;
use App\Models\UltrasoundFirstScreening;
use App\Models\UltrasoundSecondScreening;
use App\Models\UltrasoundThirdScreening;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UltrasoundService
{
    private $first_screening = [];
    private $second_screening;
    private $third_screening;
    private $patient_id;
    private $twin;
    private $response=['msg'=>''];


    public function set($request)
    {
        $this->patient_id = $request->patient_id;
        $this->twin = $request->count_of_fetus;
        foreach ($request->formData as $data) {

            $this->first_screening[] = $data['first_screening'];
            $this->second_screening[] = $data['second_screening'];
            $this->third_screening[] = $data['third_screening'];

        };
    }

    public function store($request)
    {
        /**the created at field ist required to continue the process**/
        $this->set($request);
        if ($request->ref === null) {
            $admission = new UltrasoundAdmission();
            $admission->patient_id = $this->patient_id;
            $admission->twin_pregnancy = $this->twin;
            $admission->save();
            $ref = $admission->id;
            $this->response=['msg'=>'Reference:'.$ref];
        }else{
            $ref=$request->ref;
            $this->response=['msg'=>'Data Updated'];
        }
        /** check each screening elements whether they are new or update */
            /**first screening**/
        foreach($this->first_screening as $row) {
            foreach ($row as $fs) {
                if ($fs['status'] === 'new' && $fs['valid'] === true) {
                    $this->fill_first_screening($fs, $ref,'new');
                } elseif ($fs['status'] == 'update' && $fs['valid'] === true) {
                    $this->fill_first_screening($fs, $ref,'update');
                }
            }
        }
        foreach($this->second_screening as $row_1){
            foreach($row_1 as $ss){
                if($ss['status']==='new' && $ss['valid']===true){
                    $this->fill_second_screening($ss, $ref,'new');
                }
                if($ss['status']=='update' && $ss['valid']===true){
                    $this->fill_second_screening($ss, $ref,'update');

                }
            }
        }
        foreach($this->third_screening as $row_2){
            foreach($row_2 as $ts){
                if($ts['status']==='new' && $ts['valid']===true ){
                    $this->fill_third_screening($ts, $ref,'new');
                }
                if($ts['status']=='update' && $ts['valid']===true){
                    $this->fill_third_screening($ts, $ref,'update');

                }
            }
        }
        return $this->response;

    }

    public function show($id){
        $search= UltrasoundAdmission::with(['ultrasound_first_screenings','ultrasound_second_screenings','ultrasound_third_screenings'])->find($id);
        $patient_id= $search->patient_id;
        $count= $search->twin_pregnancy;
        $first=$search->ultrasound_first_screenings->groupBy('fetus');
        $second=$search->ultrasound_second_screenings->groupBy('fetus');
        $third=$search->ultrasound_third_screenings->groupBy('fetus');

        $output=[
            'count'=>$count,
            'first'=>$first,
            'second'=>$second,
            'third'=>$third,
            'patient_id'=>$patient_id
        ];





        return response()->json($output);

    }
    private function fill_first_screening($data,$ref,$status=null){
        if($status==='new'){
            $first_screen= new UltrasoundFirstScreening();
        }else{
            $first_screen= UltrasoundFirstScreening::find($data['id']);
        }

            $first_screen->ultrasound_admission_id= $ref;
            $first_screen->wop_calculated= $data['wop_calculated'];
            $first_screen->wop_ultrasound= $data['wop_ultrasound'];
            $first_screen->wop_corrected= $data['wop_corrected'];
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
            $midwives="";
            if(count($data['midwives'])>0){
                foreach($data['midwives'] as $midwife){
                    $midwives.=$midwife.",";
                }
                $midwives=rtrim($midwives,',');
            }
            $first_screen->midwives= $midwives;
            $first_screen->save();

    }
    private function fill_second_screening($data,$ref,$status=null){

        if($status==='new'){
            $second_screen= new UltrasoundSecondScreening();
        }else{
            $second_screen= UltrasoundSecondScreening::find($data['id']);
        }
            $second_screen->ultrasound_admission_id= $ref;
            $second_screen->wop_calculated= $data['wop_calculated'];
            $second_screen->wop_ultrasound= $data['wop_ultrasound'];
            $second_screen->wop_corrected= $data['wop_corrected'];
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
            $midwives='';
            if(count($data['midwives'])>0){
                foreach($data['midwives'] as $midwife){
                    $midwives.=$midwife.",";
                }
                $midwives=rtrim($midwives,',');
            }
            $second_screen->midwives= $midwives;

            $second_screen->save();

    }
    private function fill_third_screening($data,$ref,$status=null){
        if($status=='new'){
            $third_screen= new UltrasoundThirdScreening();
        }else{
            $third_screen= UltrasoundThirdScreening::find($data['id']);
        }
            $third_screen->ultrasound_admission_id= $ref;
            $third_screen->wop_calculated= $data['wop_calculated'];
            $third_screen->wop_ultrasound= $data['wop_ultrasound'];
            $third_screen->wop_corrected= $data['wop_corrected'];
            $third_screen->placenta_type= $data['placenta_type'];
            $third_screen->normal_birth= $data['normal_birth'];
            $third_screen->normal_growth= $data['normal_growth'];
            $third_screen->amniotic_liquid= $data['amniotic_liquid'];
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

            $midwives='';
            if(count($data['midwives'])>0){
                foreach($data['midwives'] as $midwife){
                    $midwives.=$midwife.",";
                }
                $midwives=rtrim($midwives,',');
            }
            $third_screen->midwives= $midwives;
            $third_screen->save();

    }
}
