<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorkDiagnose extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function storkAdmission(){
        return $this->belongsTo(StorkAdmission::class);
}
}
