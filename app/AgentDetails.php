<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentDetails extends Model
{
   
  protected $table = "agent_details";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "agent_id",
      "action",
      "battery_check",
      "mobile_status",
      "longitude",
      "latitude",
      "is_attendace_location",
      "is_moving",
  ];

  public function agent(){
    return $this->belongsTo(Agent::class, 'agent_id' , 'id');
  }
    
}
