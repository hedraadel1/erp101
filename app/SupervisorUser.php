<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupervisorUser extends Model
{
   
  protected $table = "supervisor_users";
  protected $hidden = [];
  
  
  protected $fillable = [
      "id",
      "user_id",
      "supervisor_id",
  ];

  
}
