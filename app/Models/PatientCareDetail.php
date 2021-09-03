<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCareDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function consultation(){
        return $this->belongsTo(Consultation::class);
    }
    public function servicePrices(){
        return $this->belongsTo(ActivityPrice::class);
    }
    public static function consult($id){
        return self::where('consultation_id',$id);
    }
}
