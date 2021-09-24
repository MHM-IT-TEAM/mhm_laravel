<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Out extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'status'=>'integer'
    ];
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function out_details(){
        return $this->hasMany(OutDetail::class);
    }
    public function collector(){
        return $this->belongsTo(Collector::class);
    }

    public static function createOut($request){
        DB::transaction(function() use($request){
            $out= new Out();
            $out->fill(self::_fillHeader($request))->save();
            self::_createDetails($request->order_details,$out->id);
        });
        return Out::with(['collector','out_details'])->paginate(20);
    }
    public static function updateOut($request,$id){
        DB::transaction(function() use($request,$id){
            $out= Out::find($id);
            $out->fill(self::_fillHeader($request))->save();
            OutDetail::where('out_id',$id)->delete();
            self::_createDetails($request->order_details,$out->id);
            self::_deliver($request->order_details);
            $out->status=2;
            $out->save();
        });
        return Out::with(['collector'])->paginate(20);
    }
    private static function _fillHeader($request){
        return [
            'code'=>$request->code,
            'department_id'=>$request->department_id,
            'collector_id'=>$request->collector,
            'storage_responsible_id'=>1,
            'status'=>1,
            'due_date'=>$request->due_date,
            'remark'=>$request->remark
        ];
    }
    private static function _fillDetails($request,$id){
        return [
            'item_id'=>$request['item']['id'],
            'quantity'=>$request['quantity'],
            'out_id'=>$id
        ];
    }
    private static function _createDetails($request,$id){

        foreach($request as $line){
            $details= new OutDetail();
            $details->fill(self::_fillDetails($line,$id))->save();
        }
    }
    private static function _deliver($details){
        foreach($details as $line){
            $inventory= Inventory::where('item_id',$line['item']['id'])->first();
            $new_qty= $inventory->general-$line['quantity'];
            $inventory->general=$new_qty;
            $inventory->save();
        }

    }
}
