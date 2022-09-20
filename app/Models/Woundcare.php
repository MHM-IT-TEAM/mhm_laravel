<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Woundcare extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function woundcare_materials(){
        return $this->hasMany(WoundcareMaterial::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
