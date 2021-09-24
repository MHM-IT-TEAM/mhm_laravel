<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class In extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function inDetail(){
        return $this->hasMany(InDetail::class);
    }
    public static function create_in($request){
        DB::transaction(function()use($request){
            $in= new In();
            $in->fill(self::_fill_header($request))->save();
            foreach($request->details as $detail){
                $in_detail= new InDetail();
                $in_detail->fill(self::_fillDetails($detail,$in->id))->save();
            }
        });
    }
    public static function update_in($request,$id){
        DB::transaction(function()use($request,$id){
            $in= In::find($id);
            $in->fill(self::_fill_header($request))->save();
            InDetail::where('in_id',$id)->delete();
            foreach($request->details as $detail){
                $in_detail= new InDetail();
                $in_detail->fill(self::_fillDetails($detail,$in->id))->save();
            }
            $in->save();
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
            'in_id'=>$id
        ];
    }
    public static function validate_in($request,$id){
        DB::transaction(function()use($request,$id){
            foreach($request->details as $line){
                $inventory= Inventory::where('item_id',$line['item']['id'])->first();
                $new_qty= $inventory->general+$line['quantity'];
                $inventory->general=$new_qty;
                $inventory->save();
            }
            $in= In::find($id);
            $in->status=2;
            $in->save();
        });
    }
}
