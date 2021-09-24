<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
