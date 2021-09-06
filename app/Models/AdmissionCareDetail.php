<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionCareDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function admission(){
        return $this->belongsTo(Admission::class);
    }
    public function activity_prices(){
        return $this->belongsTo(ActivityPrice::class);
    }
    public static function consult($id){
        return self::where('consultation_id',$id);
    }
}
