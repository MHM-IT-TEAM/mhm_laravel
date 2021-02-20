<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmContact extends Model
{
    use HasFactory;
    protected $connection="patSyst";
    protected $guarded=[];
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
