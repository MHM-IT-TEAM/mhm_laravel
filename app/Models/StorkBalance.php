<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorkBalance extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function storkAdmission(){
        return $this->belongsTo(StorkAdmission::class);
    }
    public function balance_ins(){
        return $this->hasMany(StorkBalanceIn::class);
    }
    public function balance_outs(){
        return $this->hasMany(StorkBalanceOut::class);
    }
}
