<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoActionMsg extends Model
{
   
  protected $table = "auto_action_msgs";
  protected $hidden = [];
  
  public static $TYPE = [ 'daily' ,'week'];



  protected $fillable = [
      "id",
      "action_name",
      "action_value",
      "business_id",
  ];

 public function business(){
  return $this->belongsTo(Business::class , 'business_id','id');
 }


}
