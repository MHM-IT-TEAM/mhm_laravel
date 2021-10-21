<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalReferral extends Model
{
    use HasFactory;
    protected $guarded=[];

    public static function store($request){
        $ref=self::create($request);
        return response()->json([
            'success'=>true,
            'ref'=>Carbon::now()->year."/".$ref->id
        ]);
    }
}
