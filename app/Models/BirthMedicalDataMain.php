<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthMedicalDataMain extends Model
{
    use HasFactory;
    public function birth(){
        return $this->belongsTo(Birth::class);
    }
}
