<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraceCsbTransaction extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function admission(){
        return $this->belongsTo(Admission::class);
    }

    public function graceCsbTransactionDetail(){
        return $this->hasMany(GraceCsbTransactionDetail::class);
    }
}
