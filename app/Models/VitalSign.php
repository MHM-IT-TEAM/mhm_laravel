<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected function patient(){
        return $this->belongsTo(Patient::class);
    }
}
