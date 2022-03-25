<?php

namespace App\Models;

use App\Models\inventory_system\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkprogramFollowupDetail extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function item(){
        return $this->belongsTo(Item::class);
    }
    public function milkProgramFollowupDetail(){
        return $this->belongsTo(MilkprogramFollowupDetail::class);
    }
}
