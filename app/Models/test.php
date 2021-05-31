<?php
public function show($id){
    $output=[];
    $search= UltrasoundAdmission::with(['ultrasound_first_screenings'])->find($id);
    $first= $search->ultrasound_first_screenings;
    $second= $search->ultrasound_second_screenings;
    $third= $search->ultrasound_third_screenings;
    $count=$search->twin_pregnancy;
    $sec_data=[];
    $third_data=[];
    if(count($second)==1){
    for($i=0;$i<$count;$i++){
    $midwives= explode(',',$second[$i]->midwives);
    $sec_data=[
    'created_at'=>$second[$i]->created_at,
    'wop_corrected'=>$second[$i]->wop_corrected,
    'wop_calculated'=>$second[$i]->wop_calculated,
    'wop_ultrasound'=>$second[$i]->wop_ultrasound,
    'hc'=>$second[$i]->hc,
    'ac'=>$second[$i]->ac,
    'fl'=>$second[$i]->fl,
    'gs'=>$second[$i]->gs,
    'crl'=>$second[$i]->crl,
    'fhr'=>$second[$i]->fhr,
    'other'=>$second[$i]->other,
    'position_of_baby'=>$second[$i]->position_of_baby,
    'presentation_of_baby'=>$second[$i]->presentation_of_baby,
    'heartbeat'=>$second[$i]->heartbeat,
    'placenta_spontaneous'=>$second[$i]->placenta_spontaneous,
    'normal_growth'=>$second[$i]->normal_growth,
    'normal_amniotic_fluid'=>$second[$i]->normal_amniotic_fluid,
    'suspicion_for_malformation'=>$second[$i]->suspicion_for_malformation,
    'remark'=>$second[$i]->remark,
    'midwives'=>$midwives
    ];
    }
    }
    else{
    $sec_data=
    ['created_at'=>'',
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
    'placenta_spontaneous'=>'',
    'normal_growth'=>'',
    'normal_amniotic_fluid'=>'',
    'suspicion_for_malformation'=>'',
    'remark'=>'',
    'midwives'=>[]
    ];
    }

    if(count($third)>0){
    for($i=0;$i<$count;$i++){
    $midwives= explode(',',$third[$i]->midwives);
    $third_data[]=[
    'created_at'=>$third[$i]->created_at,
    'wop_corrected'=>$third[$i]->wop_corrected,
    'wop_calculated'=>$third[$i]->wop_calculated,
    'wop_ultrasound'=>$third[$i]->wop_ultrasound,
    'hc'=>$third[$i]->hc,
    'ac'=>$third[$i]->ac,
    'fl'=>$third[$i]->fl,
    'gs'=>$third[$i]->gs,
    'crl'=>$third[$i]->crl,
    'fhr'=>$third[$i]->fhr,
    'other'=>$third[$i]->other,
    'placenta_type'=>$third[$i]->placenta_type,
    'normal_birth'=>$third[$i]->normal_birth,
    'heartbeat'=>$third[$i]->heartbeat,
    'wop_equality'=>$third[$i]->wop_equality,
    'normal_growth'=>$third[$i]->normal_growth,
    'normal_amniotic_fluid'=>$third[$i]->normal_amniotic_fluid,
    'remark'=>$third[$i]->remark,
    'midwives'=>$midwives
    ];
    }
    }else{
    $third_data=[
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
    'placenta_type'=>'',
    'presentation_of_baby'=>'',
    'heartbeat'=>'',
    'wop_equality'=>'',
    'normal_growth'=>'',
    'normal_amniotic_fluid'=>'',
    'remark'=>'',
    'midwives'=>[]
    ];
    }
    for ($i=0; $i<$count;$i++){
    $midwives= explode(',',$first[$i]->midwives);
    $output[]=
    [
    'id'=>$i,
    'first_screening'=>[
    'created_at'=>Carbon::parse($first[$i]->created_at)->format('Y-m-d'),
    'wop_corrected'=>$first[$i]->wop_corrcted,
    'wop_calculated'=>$first[$i]->wop_calculated,
    'wop_ultrasound'=>$first[$i]->wop_ultrasound,
    'hc'=>$first[$i]->hc,
    'ac'=>$first[$i]->ac,
    'fl'=>$first[$i]->fl,
    'gs'=>$first[$i]->gs,
    'crl'=>$first[$i]->crl,
    'fhr'=>$first[$i]->fhr,
    'other'=>$first[$i]->other,
    'intrauterine'=>$first[$i]->ultrauterine,
    'heartbeat'=>$first[$i]->heartbeat,
    'embryo_visible'=>$first[$i]->embryo_visible,
    'remark'=>$first[$i]->remark,
    'midwives'=>$midwives
    ],
    'second_screening'=>$sec_data[$i],
    'third_screening'=>$third_data
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
    private function fill_second_screening($data,$admission_id){
    foreach($data as $fs){
    $second_screen= new UltrasoundSecondScreening();
    $second_screen->ultrasound_admission_id= $admission_id;
    $second_screen->wop_calculated= $fs['wop_calculated'];
    $second_screen->wop_ultrasound= $fs['wop_ultrasound'];
    $second_screen->wop_corrected= $fs['wop_corrected'];
    $second_screen->position_of_baby= $fs['position_of_baby'];
    $second_screen->presentation_of_baby= $fs['presentation_of_baby'];
    $second_screen->placenta_spontaneous= $fs['placenta_spontaneous'];
    $second_screen->suspicion_for_malformation= $fs['suspicion_for_malformation'];
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

    private function fill_third_screening($data,$admission_id){
    foreach($data as $ts){
    $third_screen= new UltrasoundThirdScreening();
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
