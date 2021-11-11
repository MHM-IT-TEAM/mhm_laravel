<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    use HasFactory;
    public function scopeWhereDepartment($query,$id){
        return $this->where('orderer_id',$id);
    }
}
