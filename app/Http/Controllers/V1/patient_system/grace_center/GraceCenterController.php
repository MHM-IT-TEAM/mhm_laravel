<?php

namespace App\Http\Controllers\V1\patient_system\grace_center;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\GraceCsbTransaction;
use App\Models\inventory_system\GraceCsbTransactionDetail;
use App\Models\inventory_system\Inventory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GraceCenterController extends Controller
{
    public function index(){
        return GraceCsbTransaction::with(['admission'=>function($admission){
            return $admission->with(['patient','service','service_activity'])->get();},
            'graceCsbTransactionDetail'=>function($det){
                return $det->with('item')->get();
            }
            ])->whereDate('created_at',Carbon::today())
            ->get();
    }
    public function store(Request $request){
        //update the details table
        $low_stock_item_array=[];
        foreach($request->transaction['grace_csb_transaction_detail'] as $line){
            $detail =GraceCsbTransactionDetail::find($line['id']);
            $detail->update([
                'item_id'=>$line['item']['id'],
                'given'=>$line['given'],
            ]);
            //update the inventory table
            $inventory= Inventory::find(intval($line['item']['id']));
            if($inventory->graceCenter < $line['given']){
                //check if there is a low stock item in the array
                $low_stock_item_array[]=$line;
            }
            if(count($low_stock_item_array)<1){
                $inventory->graceCenter= $inventory->graceCenter- $line['given'];
                $inventory->save();
                //update the main table
                $csb_transaction = GraceCsbTransaction::find($request->transaction['id']);
                $csb_transaction->done=1;
                $csb_transaction->remark=$request->remark;
                $csb_transaction->save();
            }
        }
        if(count($low_stock_item_array)>=1)
        {
            return response()->json([
                'success'=>false,
                'low_stock_items'=>$low_stock_item_array
            ]);
        }
        else
        {
            return response()->json([
                'success'=>true,
                'msg'=>'data submitted'
            ]);
        }

    }
}
