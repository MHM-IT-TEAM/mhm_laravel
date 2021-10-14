<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralistDiagCode extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function generalist(){
        return $this->belongsTo(Generalist::class);
    }
    public function diagCode(){
        return $this->belongsTo(DiagCode::class);
    }
    public static function store($request,$generalist_id){
        $code= new GeneralistDiagCode();
        foreach ($request as $data){
            $code->create([
                'generalist_id'=>$generalist_id,
                'diag_code_id'=>$data['code']['id'],
                'status'=>$data['status'],
                'details'=>$data['details']
            ]);
        }
    }
}
