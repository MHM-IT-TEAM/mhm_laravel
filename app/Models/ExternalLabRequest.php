<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalLabRequest extends Model
{
    use HasFactory;
    protected $connection=[];

    public function admission(){
        return $this->belongsTo(Admission::class);
    }
    public function lab_work_step(){
        return $this->belongsTo(LabWorkStep::class);
    }
    public function externalLabResults(){
        return $this->hasMany(ExternalLabResult::class);
    }
}
