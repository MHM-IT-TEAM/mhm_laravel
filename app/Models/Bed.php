<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;
    protected $connection= 'patSyst';
    public function scopeDivision($data,$id){
        return $data->where('hospital_service_division_id',$id);
    }
    public function scopeFree($data){
        return $data->where('status',0);
    }
}
