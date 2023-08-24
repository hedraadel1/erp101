<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositRequest extends Model
{
   
  protected $table = "deposit_requests";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "amount",
      "status",
      "business_id",
      "image",
      "payment_method",
  ];

  public static $STATUS = ['pending' , 'cancelled' ,'approved'] ;

  public static $PAYMENT = ['electronic_wallet' , 'bank_account'];
  
  public function business(){
    return $this->belongsTo(Business::class);
  }

    
}
