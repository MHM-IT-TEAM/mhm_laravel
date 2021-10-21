<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalConsultation extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function store($request){
        self::create($request);
        return response()->json([
            'success'=>true
        ]);
    }
}
