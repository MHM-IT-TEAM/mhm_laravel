<?php

namespace App\Http\Controllers\V1\inventory_system\low_stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LowStockController extends Controller
{
    public function list(){
        return DB::table('items')
            ->join('inventories','items.id','inventories.item_id')
            ->join('min_stocks','items.id','min_stocks.item_id')
            ->select('items.id','items.code','items.description','min_stocks.general as minStock','inventories.general as avalaible','items.item_type_id as type')
            ->whereRaw('inventories.general <= min_stocks.general and items.deleted_at IS NULL')
            ->paginate(10);
    }
}
