<?php

namespace App\Models;

use App\Models\inventory_system\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorkMedicine extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function stork_admission(){
        return $this->belongsTo(StorkAdmission::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
