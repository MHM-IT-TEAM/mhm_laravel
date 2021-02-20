<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $connection= "patSyst";
    protected $guarded=[];
    public function search($search){
        return $this->with("emContacts")->where('firstName','LIKE','%'.$search.'%')
            ->orWhere('lastName','LIKE','%'.$search.'%')
            ->orWhere('adress','LIKE','%'.$search.'%')
            ->orWhere('birthDate','LIKE','%'.$search.'%')
            ->orWhere('cin_no','LIKE','%'.$search.'%')
            ->orWhere('email','LIKE','%'.$search.'%')
            ->orWhere('cin_no','LIKE','%'.$search.'%');
    }
    public function emContacts(){
        return $this->hasMany(EmContact::class);
    }
}
