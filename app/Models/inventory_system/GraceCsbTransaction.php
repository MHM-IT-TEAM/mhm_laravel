<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Models\GraceCsbTransactionDetail;

class GraceCsbTransaction extends Model
{
    use HasFactory;
    protected $guarded =[];


    public function GraceCsbTransactions(){
        return $this->hasMany(GraceCsbTransactionDetail::class);
    }
}
