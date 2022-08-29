<?php

namespace App\Http\Controllers\V1\inventory_system\item;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\inventory_system\ItemRequest;
use App\Models\inventory_system\Inventory;
use App\Models\inventory_system\Item;
use Illuminate\Http\Request;
class ItemController extends Controller
{
    private function _success(){
        return response()->json(['success'=>true]);
    }

    public function index(Request $request)
    {
        return Item::with(['item_type','item_unit','item_administration','location','inventory','minStock'])->search($request->search_text)->applyFilter($request)->paginate(20);
    }
    public function store(Request $request)
    {
        $item=Item::createItem($request);
        return response()->json(
            ['item'=>$item]
        );
    }

    public function show($id)
    {
        return Item::with(['item_type','item_unit'])->find($id);
    }

    public function update(ItemRequest $request, $id)
    {
        $item= Item::find($id);
        return $item->fill($request->validated())->save();
    }

    public function destroy($id)
    {
        return Item::find($id)->delete();
    }

    public function getCode(Request $request){
        $item= new Item();
        return $item->getLastCode($request->code);
    }
    public function count_per_type(){
        return response()->json([
            'medicines'=>Item::where('item_type_id',1)->count(),
            'consummables'=>Item::where('item_type_id',2)->count(),
            'equipments'=>Item::where('item_type_id',3)->count(),

        ]);
    }
    public function update_inventory(Request $request){
        $inventory=Inventory::find($request->id);
        $inventory[$request->col]=$request->quantity;
        $inventory->save();
        return $this->_success();
    }

    public function check_stock_avalaibility(Request $request){
        $item= Item::find($request->item['id']);
        $inventory= Inventory::where('item_id',$request->item['id'])->get();
        $diff=intval($inventory->get('general')) - intval($request->quantity);
       return ($diff<0) ? ['id'=>$item->id,'diff'=>$diff]:null;
    }
    public function where_authorized_service($service_name){
        return Item::where($service_name,1)->get();
    }
    public function update_auth(Request $request){
        $item=Item::find($request->item['id']);
        $item[$request->orderer['name']]=$request->item[$request->orderer['name']];
        $item->save();
    }
}
