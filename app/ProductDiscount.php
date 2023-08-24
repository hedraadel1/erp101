<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
  protected $table = "product_discounts";
  protected $hidden = [];
  
  public const DiSCOUNT_TYPE = ['fixed' => 'ثابت' , 'percentage' => 'نسبة مئوية'];
  
  protected $fillable = [
      "id",
      "product_id",
      "quantity_from",
      "quantity_to",
      "discount_type",
      "discount",
      "created_at",
      "updated_at",
  ];


  public function product(){
    return $this->belongsTo(Product::class ,'product_id' , 'id');
  }
  

}
