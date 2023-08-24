<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationVideo extends Model
{
   
  protected $table = "education_videos";
  protected $hidden = [];
  
  
  protected $fillable = [
      "name",
      "category_id",
      "description",
      "video",
      "video_url",
      "video_id",
  ];

  public function category(){
    return $this->belongsTo(EducationCategory::class , 'category_id' , 'id');
  }
    
}
