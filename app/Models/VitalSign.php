<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function admission(){
        return $this->belongsTo(Admission::class);
    }
}
