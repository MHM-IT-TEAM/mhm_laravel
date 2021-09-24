<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InDetail extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function in(){
        return $this->belongsTo(In::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
