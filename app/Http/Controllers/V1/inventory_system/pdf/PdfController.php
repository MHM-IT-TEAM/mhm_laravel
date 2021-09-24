<?php

namespace App\Http\Controllers\V1\inventory_system\pdf;

use App\Http\Controllers\Controller;
use App\Models\inventory_system\Cart;
use App\Models\inventory_system\In;
use App\Models\inventory_system\Out;
use PDF;
use Illuminate\Http\Request;
use App;

class PdfController extends Controller
{
    public function shopping_list($id){

        $items=Cart::with(['cartDetails'=>function($data){
            return $data->with('item')->get();
        }])->find($id);
        view()->share('items',$items);
        $pdf = PDF::loadView('pdf.shopping_list', $items);
        return $pdf->download($items->code.'.pdf');
    }
    public function stock_entry($id){
        $entries= In::with(['inDetail'=>function($data){
            return $data->with(['item'=>function($item){
                return $item->where('deleted_at',null)->get();
            }])->get();
        }])->find($id);
        view()->share('entries',$entries);
        $pdf = PDF::loadView('pdf.entry', $entries);
        return $pdf->download($entries->code.'.pdf');
    }

    public function delivered_out($id){
        $order= Out::with(['out_details'=>function($data){
            return $data->with(['item'=>function($src){
                return $src->with(['inventory'])->get();
            }])->get();
        },'department','collector'])->find($id);
        view()->share('order',$order);
        $pdf = PDF::loadView('pdf.delivered_out', $order);
        return $pdf->download($order->code.'.pdf');
    }
}
