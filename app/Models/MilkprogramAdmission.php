<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkprogramAdmission extends Model
{
    use HasFactory;
    public function milkprogramFollowups(){
        return $this->hasMany(MilkprogramFollowup::class);
    }
}
