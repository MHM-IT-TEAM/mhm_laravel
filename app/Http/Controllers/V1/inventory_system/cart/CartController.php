<?php

namespace App\Http\Controllers\V1\inventory_system\cart;

use App\Http\Controllers\Controller;
use App\Models\inventory_system\Cart;
use App\Models\inventory_system\CartDetail;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        return Cart::with(['cartDetails'=>function($data){
            return $data->with('item')->get();
        }])->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Cart::create_cart($request);
        return response()->json(['success'=>true]);
    }
    public function show($id)
    {
        return Cart::with(['cartDetails'=>function($data){
            return $data->with(['item'=>function($item){
                return $item->where('deleted_at',null)->get();
            }])->get();
        }])->find($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        return Cart::update_cart($request,$id);
    }

    public function destroy($id)
    {
        CartDetail::where('cart_id',$id)->delete();
        Cart::find($id)->delete();
        return response()->json(['success'=>true]);
    }
    public function lastCode(){
        $cart=Cart::latest()->first();
        if($cart!==null)return $cart->code;
        return response()->json(['msg'=>'no data']);
    }
}
