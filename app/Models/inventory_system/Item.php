<?php

namespace App\Models\inventory_system;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=[];


    public function item_administration(){
        return $this->belongsTo(ItemAdministration::class);
    }
    public function inventory(){
        return $this->hasOne(Inventory::class);
    }
    public function minStock(){
        return $this->hasOne(MinStock::class);
    }
    public function location(){
        return $this->belongsTo(Location::class);
    }
    public function item_unit(){
        return $this->belongsTo(ItemUnit::class);
    }
    public function item_type(){
        return $this->belongsTo(ItemType::class);
    }
    public function outDetails(){
        return $this->hasMany(OutDetail::class);
    }
    public function scopeWhereType($query,$type){
        return $query->where('item_type_id',$type);
    }
    public function scopeWhereBarcode($query,$barcode){
        return $query->where('type_id',$barcode);
    }
    public function scopeWhereCode($query,$code){
        return $query->where('code','like','%'.$code.'%');
    }
    public function scopeSearch($query,$search){
        return $query->where('code','like','%'.$search.'%')
            ->orWhere('description','like','%'.$search.'%')
            ->orWhere('dci','like','%'.$search.'%');
    }
    public static function createItem($request){
        $item= self::create($request->except(['gl_min_stock','entry_qty']));
        Inventory::create([
            'item_id'=>$item->id,
            'general'=>$request->entry_qty
        ]);
        MinStock::create([
            'item_id'=>$item->id,
            'general'=>$request->gl_min_stock
        ]);
        return $item;
    }
    public function scopeGetLastCode($query,$prefix){
        return $this->where('description','like',$prefix.'%')->orderBy('id','desc')->take(1)->pluck('code');
    }
    public function scopeApplyFilter($query, $filter){
        $filters= collect($filter);
        if($filters->has('category')){
            if($filters['category'] !== null ){
                return $query->whereType($filters['category']);
            }
        }
    }
}
