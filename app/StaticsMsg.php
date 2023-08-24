<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticsMsg extends Model
{
   
  protected $table = "statics_msg";
  protected $hidden = [];
  
  public static $TYPE = [ 'daily' ,'week'];

  public static $ACTIONS = [ 
      'total_sells' ,
      'total_profits',
      'total_purchases',
      'total_rosary',  //اجمالي الوردية
      'total_expenses',
      'total_indebtedness_customer',
      'total_indebtedness_supplier',
  ];

  public static $DAY = [
      "saturday",
      "sunday",
      "monday",
      "tuesday",
      "wednesday",
      "thursday",
      "friday",
  ];

  protected $fillable = [
      "id",
      "business_id",
      "action_name",
      "action_time",
      "action_duration",
      "action_day",
  ];

  public function business(){
    return $this->belongsTo(Business::class);
  }


}
