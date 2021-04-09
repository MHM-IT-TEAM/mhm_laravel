<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;
    protected $connection= 'patSyst';
    public function whereDivision($id){
        return $this->where('hospital_service_division_id',$id)->get();
    }
}
