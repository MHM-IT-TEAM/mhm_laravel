<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraceCsbTransactionDetail extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];


    public function graceCsbTransaction(){
        return $this->belongsTo(GraceCsbTransaction::class);
    }
}
