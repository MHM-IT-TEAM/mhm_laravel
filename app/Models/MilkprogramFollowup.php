<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkprogramFollowup extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function milkProgramAdmission(){
        return $this->belongsTo(MilkprogramAdmission::class);
    }
    public function milkProgramFollowupDetails(){
        return $this->hasMany(MilkprogramFollowupDetail::class);
    }
}
