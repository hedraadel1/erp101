<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
  protected $table = "support_tickets";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "business_id",
      "title",
      "user_id",
      "priority",
      "date",
      "description",
      "file",
      "status",
      "created_at",
      "updated_at",
  ];


  public static $PRIORITY = ['low' =>'low' , 'medium'=>'medium' , 'high'=>'high'];
  const STATUS = [
    'open' => 'open',
    'in_process' => 'in_process',
    'answered' => 'answered',
    'on_hold' => 'on_hold',
    'cancelled' => 'cancelled',
];

public function business(){
  return $this->belongsTo(Business::class ,'business_id' , 'id');
}

public function user(){
  return $this->belongsTo(User::class ,'user_id' , 'id');
}
}
