<?php

namespace App\Http\Controllers\V1\inventory_system\app;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\inventory_system\ItemAdministration;
use App\Models\inventory_system\ItemType;
use App\Models\inventory_system\ItemUnit;
use App\Models\inventory_system\Location;
use App\Models\inventory_system\Orderer;
use App\Models\inventory_system\Out;
use Illuminate\Http\Request;

class BootstrapController extends Controller
{
    public function bootstrap(){
        return response()->json([
            'item_units'=>ItemUnit::all(),
            'item_type'=>ItemType::all(),
            'item_administration'=>ItemAdministration::all(),
            'location'=>Location::all(),
            'department'=>Department::all(),
            'orderers'=>Orderer::all(),
            'out_orders'=>Out::with(['collector','out_details'])->where('status',1)->paginate(10)
        ]);
    }
}
