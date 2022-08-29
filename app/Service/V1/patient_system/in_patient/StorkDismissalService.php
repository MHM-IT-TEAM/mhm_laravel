<?php


namespace App\Service\V1\patient_system\in_patient;


use App\Models\Bed;
use App\Models\StorkAdmission;
use App\Models\StorkDismissal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StorkDismissalService
{
    public static function store($request){
        DB::transaction(function()use ($request){
            $dismissal= new StorkDismissal();
            $dismissal->create(self::_fill($request));
            //mark stork_admission as done
            $admission= StorkAdmission::find($request->stork_admission_id);
            $admission->dismissed=true;
            $admission->save();
            // the bed should be free again
            $bed= Bed::find($request->bed_id);
            $bed->occupied= 0;
            $bed->save();
        });
        return response()->json(['success'=>true]);
    }

    private static function _fill($data){
        return [
          'stork_admission_id'=>$data->stork_admission_id,
          'dismissal_date'=>$data->dismissal_date,
          'dismissal_time'=>$data->dismissal_time,
          'dismissal_diagnosis'=>$data->dismissal_diagnosis,
          'bp_l'=>$data->bp_l,
          'bp_r'=>$data->bp_r,
          'pulse'=>$data->pulse,
          'weight'=>$data->weight,
          'temp'=>$data->temp,
          'spo2'=>$data->spo2,
            'user_id'=>$data->user_id
        ];
    }
}
