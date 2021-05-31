<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vaccinCertificate extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $connection='patSyst';
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
