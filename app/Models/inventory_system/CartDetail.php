<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function item(){
        return $this->belongsTo(Item::class);
    }
}
