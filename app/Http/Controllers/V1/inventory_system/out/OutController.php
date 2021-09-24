<?php

namespace App\Http\Controllers\V1\inventory_system\out;

use App\Http\Controllers\Controller;
use App\Models\inventory_system\Inventory;
use App\Models\inventory_system\Out;
use App\Models\inventory_system\OutDetail;
use Illuminate\Http\Request;

class OutController extends Controller
{
    public function index()
    {
        return response()->json([
           'pending'=> Out::with(['collector','out_details'])->where('status',1)->paginate(10),
            'delivered'=>Out::with(['collector','out_details'])->where('status',2)->paginate(10),
        ]);
    }

    public function pending_list(){
        return Out::with(['collector','out_details'])->where('status',1)->paginate(10);
    }

    public function delivered_list(){
        return Out::with(['collector','out_details'])->where('status',2)->paginate(10);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        return Out::createOut($request);
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        return Out::with(['out_details'=>function($data){
            return $data->with(['item'=>function($src){
                return $src->with(['inventory'])->get();
            }])->get();
        }])->find($id);
    }
    public function update(Request $request, $id)
    {
       return Out::updateOut($request,$id);
    }
    public function destroy($id)
    {
        OutDetail::where('out_id',$id)->delete();
        Out::find($id)->delete();
    }
    public function lastCode(){
        $code=Out::latest()->first();
        if($code!==null)return $code->code;
    }

}
