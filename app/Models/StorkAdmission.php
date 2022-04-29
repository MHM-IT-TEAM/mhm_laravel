<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorkAdmission extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function bed(){
        return $this->belongsTo(Bed::class);
    }

    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
