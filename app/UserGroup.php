<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
   
  protected $table = "user_groups";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "user_id",
      "group_id",
  ];
    
}
