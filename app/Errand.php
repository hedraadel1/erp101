<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Errand extends Model
{
   
  protected $table = "errands";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "business_id",
      "user_id",
      "date_time_from",
      "date_time_to",
      "notes",
  ];

  public function user(){
    return $this->belongsTo(User::class , 'user_id' , 'id');
  }
  public function business(){
    return $this->belongsTo(Business::class);
  }

}
