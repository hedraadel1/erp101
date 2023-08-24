<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseInventory extends Model
{
   
  protected $table = "warehouse_inventoris";
  protected $hidden = [];
  
  
  protected $fillable = [
      "business_id",
      "location_id",
      "date",
      "notes",
  ];

  
  public function business(){
    return $this->belongsTo(Business::class);
  }
  
  public function location(){
    return $this->belongsTo(BusinessLocation::class);
  }

  public function inventory_products(){
    return $this->hasMany(WarehouseInventoryProduct::class , 'inventory_id' , 'id');
  }

    
}
