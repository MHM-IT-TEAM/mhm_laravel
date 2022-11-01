<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorkComment extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function stork_admission(){
        return $this->belongsTo(StorkAdmission::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
