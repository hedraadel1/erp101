<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSerial extends Model
{
   
  protected $table = "product_serials";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "business_id",
      "serial_code",
      "is_used",
      "product_id",
  ];

  public function product(){
    return $this->belongsTo(Product::class , 'product_id' , 'id');
  }
  public function business(){
    return $this->belongsTo(Business::class);
  }
 
  
}
