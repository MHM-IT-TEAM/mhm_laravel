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
    public function balances(){
        return $this->hasMany(StorkBalance::class);
    }
    public function pregnancy_checkups(){
        return $this->hasMany(StorkPregnancyCheckup::class);
    }
    public function stork_dismissal(){
        return $this->hasOne(StorkDismissal::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }

}
