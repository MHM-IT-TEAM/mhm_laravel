<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorkPlanDetail extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function stork_plan_detail(){
        return $this->belongsTo(StorkPlanDetail::class);
    }
}
