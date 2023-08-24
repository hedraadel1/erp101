<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
   
  protected $table = "zone";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "business_id",
      "zone_name",
      "zone_long",
      "zone_lat",
      "max_away",
  ];

  public function users(){
    return $this->hasMany(User::class , 'zone_id' , 'id');
  }
  public function business(){
    return $this->belongsTo(Business::class);
  }
 
  public function userHasZone($id){
    $zone = User::where('id' , $id)->first();
    // dd($zone);
    return $zone ? true : false;
  }
}
