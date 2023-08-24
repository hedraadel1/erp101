<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportReplay extends Model
{
  protected $table = "support_replay";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "business_id",
      "user_id",
      "comment",
      "ticket_id",
      "file",
      "created_at",
      "updated_at",
  ];

  public function ticket(){
    return $this->belongsTo(SupportTicket::class , 'ticket_id' , 'id');
  }
  public function user(){
    return $this->belongsTo(User::class ,'user_id' , 'id');
  }
  

}
