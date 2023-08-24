<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceBooking extends Model
{
  protected $table = "invoice_booking";
  protected $hidden = [];
  
  public const STATUS = ['pending'=>'pending','complate'=>'complate','cancel'=>'cancel'];
  
  protected $fillable = [
      "id",
      "business_id",
      "invoice_id",
      "customer_id",
      "total_invoice",
      "total_paid",
      "status",
      "created_at",
      "updated_at",
  ];


  public function contact()
    {
        return $this->belongsTo(\App\Contact::class, 'customer_id');
    }
  public function product(){
    return $this->belongsTo(Product::class ,'product_id' , 'id');
  }
  public function invoiceBookingDetails(){
    return $this->hasMany(ProductBooking::class ,'invoice_booking_id','id');
  }
  

}
