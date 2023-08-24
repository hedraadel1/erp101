<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
   
  protected $table = "wallet";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "amount",
      "free_money",
      "business_id",
  ];

  
  public function business(){
    return $this->belongsTo(Business::class);
  }

    
}
