<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorkPlan extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function stork_admission(){
        return $this->belongsTo(StorkAdmission::class);
    }
    public function stork_plan_details(){
        return $this->hasMany(StorkPlanDetail::class);
    }
}
