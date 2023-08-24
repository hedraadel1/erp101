<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseInventoryProduct extends Model
{
   
  protected $table = "warehouse_inventory_products";
  protected $hidden = [];
  
  
  protected $fillable = [
      "inventory_id",
      "product_id",
      "variation_id",
      "old_quantity",
      "new_quantity",
      "is_inability",
  ];

  
  public function product(){
    return $this->belongsTo(Product::class,'product_id' ,'id');
  }


    
}
