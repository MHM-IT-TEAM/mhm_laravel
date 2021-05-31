<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BabyCheckup extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $casts =[
        'created_at'=>'date:Y-m-d'
    ];
    protected $guarded=[];

}
