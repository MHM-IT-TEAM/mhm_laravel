<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LunchOrder extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function admission(){
        return $this->belongsTo(Admission::class);
    }
    public function lunch_menu(){
        return $this->belongsTo(LunchMenu::class);
    }
}
