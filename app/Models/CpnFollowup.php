<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpnFollowup extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];
    protected $casts =[
      'created_at'=>'date:Y-m-d'
    ];
}
