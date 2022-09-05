<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalConsultation extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function internalConsultationType(){
        return $this->belongsTo(InternalConsultationType::class);
    }
    public static function store($request){
        self::create($request->all());
        //create a new admission
        return response()->json(['success'=>true,'msg'=>'data submitted']);
    }
}
