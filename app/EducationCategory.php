<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationCategory extends Model
{
   
  protected $table = "education_categories";
  protected $hidden = [];
  
  
  protected $fillable = [
      "name",
  ];

  public function videos(){
    return $this->hasMany(EducationVideo::class , 'category_id' );
  }

    
}
