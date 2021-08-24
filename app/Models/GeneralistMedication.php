<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralistMedication extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];

    //Relationship
    public function generalist(){
        return $this->belongsTo(Generalist::class);
    }
}
