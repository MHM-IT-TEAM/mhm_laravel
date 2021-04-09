<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CpnAdmission extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];
}
