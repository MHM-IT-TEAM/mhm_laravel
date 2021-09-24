<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Models\Models\GraceCsbTransaction;

class GraceCsbTransactionDetail extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function GraceCsbTransaction(){
        return $this->belongsTo(GraceCsbTransaction::class);
    }
}
