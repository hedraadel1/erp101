<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSettingScreen extends Model
{

    protected $guarded = [] ;
    protected $table = "user_setting_screens" ;


    public function user(){
        return $this->belongsTo(User::class,'user_id' , 'id');
    }
    public function business(){
        return $this->belongsTo(Busines::class,'business_id' , 'id');
    }
}
