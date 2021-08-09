<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthUsedMedicine extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];

    public function birth(){
        return $this->belongsTo(Birth::class);
    }
}