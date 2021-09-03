<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CpnFollowup extends Model
{
    use HasFactory;
    use softDeletes;

    protected $guarded=[];
    protected $casts =[
      'created_at'=>'date:Y-m-d'
    ];
}
