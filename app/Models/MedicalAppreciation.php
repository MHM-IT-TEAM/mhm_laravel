<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAppreciation extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $connection='patSyst';
    protected $casts=[
        'created_at' => 'datetime:Y-m-d',
    ];

    public function medicalAppreciationComments(){
        return $this->hasMany(MedicalAppreciationComment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
