<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];


    public function cartDetails(){
        return $this->hasMany(CartDetail::class);
    }
    public static function create_cart($request){
        DB::transaction(function()use($request){
            $cart= new Cart();
            $cart->fill(self::_fill_header($request))->save();
            foreach($request->details as $detail){
                $cart_detail= new CartDetail();
                $cart_detail->fill(self::_fillDetails($detail,$cart->id))->save();
            }

        });
    }
    public static function update_cart($request,$id){
        DB::transaction(function()use($request,$id){
            $cart= Cart::find($id);
            $cart->fill(self::_fill_header($request))->save();
            CartDetail::where('cart_id',$id)->delete();
            foreach($request->details as $detail){
                $cart_detail= new CartDetail();
                $cart_detail->fill(self::_fillDetails($detail,$cart->id))->save();
            }
            $cart->status=2;
            $cart->save();
        });
    }
    private static function _fill_header($request){
        return [
            'code'=>$request->code,
            'status'=>$request->status,
            'remark'=>$request->remark
        ];
    }
    private static function _fillDetails($request,$id){
        return [
            'item_id'=>$request['item']['id'],
            'quantity'=>$request['quantity'],
            'cart_id'=>$id
        ];
    }
}
