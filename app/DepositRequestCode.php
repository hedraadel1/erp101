<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositRequestCode extends Model
{
   
  protected $table = "deposit_requests_code";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "code",
      "value",
      "status",
  ];

    
}
