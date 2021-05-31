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
            if ($this->first_screening[0]["created_at"] !== null) {
                $admission = new UltrasoundAdmission();
                $admission->patient_id = $this->patient_id;
                $admission->twin_pregnancy = $this->twin;
                $admission->save();
                $admission_id = $admission->id;
                /** Insert into the first_screening table */
                $this->fill_first_screening($this->first_screening, $admission_id);
            }
        } else {
                if ($request->formStatus['second_screening']==='new' && $this->second_screening[0]["valid"] === true) {
                    $this->fill_second_screening($this->second_screening, $request->ref);
                }
                elseif($request->formStatus['second_screening']==='update'){
                   $this->fill_second_screening($this->second_screening,$request->ref,'update');
                }

                if ($request->formStatus['third_screening']==='new' && $this->third_screening[0]["valid"] ===true) {
                    $this->fill_third_screening($this->third_screening, $request->ref,'new');
                }elseif($request->formStatus['third_screening']==='update'){
                    $this->fill_third_screening($this->third_screening, $request->ref,'update');
                }
        }
    }

    public function show($id){
        $search= UltrasoundAdmission::with(['ultrasound_first_screenings','ultrasound_second_screenings','ultrasound_third_screenings'])->find($id);
        $patient_id= $search->patient_id;
        $output=[];
        $count= $search->twin_pregnancy;
        $first=$search->ultrasound_first_screenings;
        $second=$search->ultrasound_second_screenings;
        $third=$search->ultrasound_third_screenings;
        $second_null=[
            'created_at'=>'',
            'wop_corrected'=>'',
            'wop_calculated'=>'',
            'wop_ultrasound'=>'',
            'hc'=>'',
            'ac'=>'',
            'fl'=>'',
            'gs'=>'',
            'crl'=>'',
            'fhr'=>'',
            'other'=>'',
            'position_of_baby'=>'',
            'presentation_of_baby'=>'',
            'heartbeat'=>'',
            'placenta_type'=>false,
            'normal_growth'=>'',
            'normal_amniotic_fluid'=>'',
            'suspicion_for_malformation'=>'',
            'malformation_explanation'=>'',
            'remark'=>'',
            'midwives'=>[],
            'status'=>'new',
            'valid'=>false
        ];
        $third_null=[
              'created_at'=>'',
              'wop_calculated'=>'',
              'wop_corrected'=>'',
              'wop_ultrasound'=>'',
              'hc'=>"",
              'ac'=>"",
              'fl'=>"",
              'gs'=>"",
              'crl'=>"",
              'fhr'=>"",
              'other'=>"",
              'normal_growth'=>false,
              'placenta_type'=>'',
              'normal_birth'=>'',
              'amniotic_liquid'=>'',
              'wop_equality'=>'',
              'midwives'=>[],
              'remark'=>'',
              'status'=>'new',
              'valid'=>false
        ];
        $second_data=[];
        $third_data=[];
        for($i=0;$i<$count;$i++){
            $second_data[]=count($second)==0?[$second_null,$second_null]:$second;
            $third_data[]=count($third)==0?[$third_null,$third_null]:$third;
            $midwives_first= explode(',',$first[$i]->midwives);

            if(is_array($second_data[$i][$i]['midwives'])){
                $midwives_second=count($second_data[$i][$i]['midwives'])>0?explode(',',$second_data[$i][$i]['midwives']):[];
            }else{
                $midwives_second=$second_data[$i][$i]['midwives']!==''?explode(',',$second_data[$i][$i]['midwives']):[];
            }
            if(is_array($third_data[$i][$i]['midwives'])){
                $midwives_third=count($third_data[$i][$i]['midwives'])>0? explode(',',$third_data[$i][$i]['midwives']):[];
            }else{
                $midwives_third=$third_data[$i][$i]['midwives']!==''? explode(',',$third_data[$i][$i]['midwives']):[];
            }
            $output[]=[
                'id'=>$i,
                'patient_id'=>$patient_id,
                'first_screening'=>[[
                      'created_at'=>Carbon::parse($first[$i]->created_at)->format('Y-m-d'),
                      'wop_calculated'=>$first[$i]->wop_calculated,
                      'wop_corrected'=>$first[$i]->wop_corrected,
                      'wop_ultrasound'=>$first[$i]->wop_ultrasound,
                      'hc'=>$first[$i]->hc,
                      'ac'=>$first[$i]->ac,
                      'fl'=>$first[$i]->fl,
                      'gs'=>$first[$i]->gs,
                      'crl'=>$first[$i]->crl,
                      'fhr'=>$first[$i]->fhr,
                      'other'=>$first[$i]->other,
                      'intrauterine'=>$first[$i]->intrauterine,
                      'heartbeat'=>$first[$i]->heartbeat,
                      'embryo_visible'=>$first[$i]->embryo_visible,
                      'remark'=>$first[$i]->remark,
                      'midwives'=>$midwives_first
                ]],
                'second_screening'=>[
                    'created_at'=>Carbon::parse($second_data[$i][$i]['created_at'])->format('Y-m-d'),
                    'wop_corrected'=>$second_data[$i][$i]['wop_corrected'],
                    'wop_calculated'=>$second_data[$i][$i]['wop_calculated'],
                    'wop_ultrasound'=>$second_data[$i][$i]['wop_ultrasound'],
                    'hc'=>$second_data[$i][$i]['hc'],
                    'ac'=>$second_data[$i][$i]['ac'],
                    'fl'=>$second_data[$i][$i]['fl'],
                    'gs'=>$second_data[$i][$i]['gs'],
                    'crl'=>$second_data[$i][$i]['crl'],
                    'fhr'=>$second_data[$i][$i]['fhr'],
                    'other'=>$second_data[$i][$i]['other'],
                    'position_of_baby'=>$second_data[$i][$i]['position_of_baby'],
                    'presentation_of_baby'=>$second_data[$i][$i]['presentation_of_baby'],
                    'heartbeat'=>$second_data[$i][$i]['heartbeat'],
                    'placenta_type'=>$second_data[$i][$i]['placenta_type'],
                    'normal_growth'=>$second_data[$i][$i]['normal_growth'],
                    'normal_amniotic_fluid'=>$second_data[$i][$i]['normal_amniotic_fluid'],
                    'suspicion_for_malformation'=>$second_data[$i][$i]['suspicion_for_malformation'],
                    'malformation_explanation'=>$second_data[$i][$i]['malformation_explanation'],
                    'remark'=>$second_data[$i][$i]['remark'],
                    'midwives'=>$midwives_second,
                    'status'=>$second_data[$i][$i]['status'],
                    'valid'=>$second_data[$i][$i]['valid']

                ],
                'third_screening'=>[
                    'created_at'=>Carbon::parse($third_data[$i][$i]['created_at'])->format('Y-m-d'),
                    'wop_calculated'=>$third_data[$i][$i]['wop_calculated'],
                    'wop_corrected'=>$third_data[$i][$i]['wop_corrected'],
                    'wop_ultrasound'=>$third_data[$i][$i]['wop_ultrasound'],
                    'hc'=>$third_data[$i][$i]['hc'],
                    'ac'=>$third_data[$i][$i]['ac'],
                    'fl'=>$third_data[$i][$i]['fl'],
                    'gs'=>$third_data[$i][$i]['gs'],
                    'crl'=>$third_data[$i][$i]['crl'],
                    'fhr'=>$third_data[$i][$i]['fhr'],
                    'other'=>$third_data[$i][$i]['other'],
                    'normal_growth'=>false,
                    'placenta_type'=>$third_data[$i][$i]['placenta_type'],
                    'normal_birth'=>$third_data[$i][$i]['normal_birth'],
                    'amniotic_liquid'=>$third_data[$i][$i]['amniotic_liquid'],
                    'wop_equality'=>intval($third_data[$i][$i]['wop_equality']),
                    'midwives'=>$midwives_third,
                    'status'=>$third_data[$i][$i]['status'],
                    'remark'=>$third_data[$i][$i]['remark'],
                    'valid'=>$third_data[$i][$i]['valid'],
                ],
            ];
        }

        return response()->json($output);

    }
    private function fill_first_screening($data,$admission_id){
        foreach($data as $fs){
            $first_screen= new UltrasoundFirstScreening();
            $first_screen->ultrasound_admission_id= $admission_id;
            $first_screen->wop_calculated= $fs['wop_calculated'];
            $first_screen->wop_ultrasound= $fs['wop_ultrasound'];
            $first_screen->wop_corrected= $fs['wop_corrected'];
            $first_screen->intrauterine= $fs['intrauterine'];
            $first_screen->heartbeat= $fs['heartbeat'];
            $first_screen->embryo_visible= $fs['embryo_visible'];
            $first_screen->remark= $fs['remark'];
            $first_screen->other= $fs['other'];
            $first_screen->hc= $fs['hc'];
            $first_screen->ac= $fs['ac'];
            $first_screen->fl= $fs['fl'];
            $first_screen->gs= $fs['gs'];
            $first_screen->crl= $fs['crl'];
            $first_screen->fhr= $fs['fhr'];
            $midwives="";
            if(count($fs['midwives'])>0){
                foreach($fs['midwives'] as $midwife){
                    $midwives.=$midwife.",";
                }
                $midwives=rtrim($midwives,',');
            }
            $first_screen->midwives= $midwives;
            $first_screen->save();
        }
    }
    private function fill_second_screening($data,$admission_id,$update=null){
        foreach($data as $fs){
            if($update=='new'){
                $second_screen= new UltrasoundSecondScreening();
            }else{
                $second_screen= UltrasoundSecondScreening::where('ultrasound_admission_id',$admission_id)->first();
            }
            $second_screen->ultrasound_admission_id= $admission_id;
            $second_screen->wop_calculated= $fs['wop_calculated'];
            $second_screen->wop_ultrasound= $fs['wop_ultrasound'];
            $second_screen->wop_corrected= $fs['wop_corrected'];
            $second_screen->position_of_baby= $fs['position_of_baby'];
            $second_screen->presentation_of_baby= $fs['presentation_of_baby'];
            $second_screen->placenta_type= $fs['placenta_type'];
            $second_screen->normal_growth= $fs['normal_growth'];
            $second_screen->normal_amniotic_fluid= $fs['normal_amniotic_fluid'];
            $second_screen->suspicion_for_malformation= $fs['suspicion_for_malformation'];
            $second_screen->malformation_explanation= $fs['malformation_explanation'];
            $second_screen->remark= $fs['remark'];
            $second_screen->heartbeat= $fs['heartbeat'];
            $second_screen->other= $fs['other'];
            $second_screen->hc= $fs['hc'];
            $second_screen->ac= $fs['ac'];
            $second_screen->fl= $fs['fl'];
            $second_screen->gs= $fs['gs'];
            $second_screen->crl= $fs['crl'];
            $second_screen->fhr= $fs['fhr'];
            $midwives='';
            if(count($fs['midwives'])>0){
                foreach($fs['midwives'] as $midwife){
                    $midwives.=$midwife.",";
                }
                $midwives=rtrim($midwives,',');
            }
            $second_screen->midwives= $midwives;

            $second_screen->save();
        }
    }
    private function fill_third_screening($data,$admission_id,$update=null){
        foreach($data as $ts){
            if($update=='new'){
                $third_screen= new UltrasoundThirdScreening();
            }else{
                $third_screen= UltrasoundThirdScreening::where('ultrasound_admission_id',$admission_id)->first();
            }
            $third_screen->ultrasound_admission_id= $admission_id;
            $third_screen->wop_calculated= $ts['wop_calculated'];
            $third_screen->wop_ultrasound= $ts['wop_ultrasound'];
            $third_screen->wop_corrected= $ts['wop_corrected'];
            $third_screen->placenta_type= $ts['placenta_type'];
            $third_screen->normal_birth= $ts['normal_birth'];
            $third_screen->normal_growth= $ts['normal_growth'];
            $third_screen->amniotic_liquid= $ts['amniotic_liquid'];
            $third_screen->wop_equality= $ts['wop_equality'];
            $third_screen->hc= $ts['hc'];
            $third_screen->ac= $ts['ac'];
            $third_screen->fl= $ts['fl'];
            $third_screen->gs= $ts['gs'];
            $third_screen->crl= $ts['crl'];
            $third_screen->fhr= $ts['fhr'];
            $third_screen->other= $ts['other'];
            $third_screen->remark= $ts['remark'];
            $midwives='';
            if(count($ts['midwives'])>0){
                foreach($ts['midwives'] as $midwife){
                    $midwives.=$midwife.",";
                }
                $midwives=rtrim($midwives,',');
            }
            $third_screen->midwives= $midwives;
            $third_screen->save();
        }
    }
}
