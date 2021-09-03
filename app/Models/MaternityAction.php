<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaternityAction extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function maternityActionList(){
        return $this->belongsTo(MaternityActionList::class);
    }
}
