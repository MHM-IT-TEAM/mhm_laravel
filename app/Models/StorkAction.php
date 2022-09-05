<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorkAction extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts=[
        'created_at'=>'datetime:d-M-Y',
    ];
    public function storkActionGroup(){
        return $this->belongsTo(StorkActionGroup::class);
    }
}
