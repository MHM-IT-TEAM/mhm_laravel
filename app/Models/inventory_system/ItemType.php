<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;
    public function items(){
        return $this->hasMany(Item::class);
    }
}
