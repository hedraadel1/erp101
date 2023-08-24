<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
   
  protected $table = "agents";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "user_id",
      "business_id",
  ];

  public function agentDetails(){
    return $this->hasMany(AgentDetails::class , 'agent_id' , 'id');
  }
  public function user(){
    return $this->belongsTo(User::class);
  }
  public function getLocationName($id){
    $user =  User::findOrFail($id);
    return BusinessLocation::where('location_id',$user->location_id)->where('business_id',$user->business_id)->first()->name ??'';
    }
    
}
