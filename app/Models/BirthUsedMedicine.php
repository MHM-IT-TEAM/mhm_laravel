<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthUsedMedicine extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function birth(){
        return $this->belongsTo(Birth::class);
    }
}
