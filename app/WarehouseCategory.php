<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseCategory extends Model
{
   
  protected $table = "warhouse_categories";
  protected $hidden = [];
  
  
  protected $fillable = [
      "business_id",
      "name",
      "description",
  ];

  
  public function business(){
    return $this->belongsTo(Business::class);
  }

    
}
