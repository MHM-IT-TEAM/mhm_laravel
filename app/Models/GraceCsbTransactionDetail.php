<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraceCsbTransactionDetail extends Model
{
    use HasFactory;
    protected $connection='inventSyst';
    protected $guarded=[];


    public function graceCsbTransaction(){
        return $this->belongsTo(GraceCsbTransaction::class);
    }
    public static function create_detail($request){
        $request= collect($request);
        return self::create(
           [
               'grace_csb_transaction_id'=>$request->get('grace_csb_transaction_id'),
               'item_id'=>$request->get('item')['id'],
               'breakfast'=>$request->get('breakfast'),
               'lunch'=>$request->get('lunch'),
               'dinner'=>$request->get('dinner'),
               'to_give'=>$request->get('to_give'),
               'given'=>$request->get('given')
           ]
        );
    }
}
