<?php

namespace App\Http\Controllers\V1\inventory_system\in;

use App\Http\Controllers\Controller;
use App\Models\inventory_system\Cart;
use App\Models\inventory_system\In;
use Illuminate\Http\Request;

class InController extends Controller
{
    private function _success(){
        return response()->json(['success'=>true]);
    }
    public function index()
    {
        return In::with(['InDetail'=>function($data){
            return $data->with('item')->get();
        }])->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        In::create_in($request);
        return $this->_success();
    }

    public function show($id)
    {
        return In::with(['inDetail'=>function($data){
            return $data->with(['item'=>function($item){
                return $item->where('deleted_at',null)->get();
            }])->get();
        }])->find($id);
    }

    public function validate_stock(Request $request, $id)
    {
         In::validate_in($request,$id);
        return $this->_success();

    }

    public function update(Request $request, $id)
    {
        In::update_in($request,$id);
        return $this->_success();

    }
    public function destroy($id)
    {
        //
    }
    public function lastCode(){
        $in=In::latest()->first();
        if($in!==null)return $in->code;
        return response()->json(['msg'=>'no data']);
    }
}
