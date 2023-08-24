<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingGoFast extends Model
{
   
  protected $table = "setting_go_fast";
  protected $hidden = [];
  
  
  protected $fillable = [
      "name",
      "menu_name",
      "menu_url",
      
  ];


    
}
