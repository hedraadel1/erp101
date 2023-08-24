<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBooking extends Model
{
  protected $table = "product_booking";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "invoice_booking_id",
      "product_id",
      "product_price",
      "product_qty",
      "created_at",
      "updated_at",
  ];


  public function product(){
    return $this->belongsTo(Product::class ,'product_id' , 'id');
  }
  public function invoiceBooking(){
    return $this->belongsTo(InvoiceBooking::class ,'invoice_booking_id' , 'id');
  }
  

}
