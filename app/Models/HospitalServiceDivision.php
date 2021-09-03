<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalServiceDivision extends Model
{
    use HasFactory;

    public function whereService($id){
        return $this->where('hospital_service_id',$id);
    }
}
