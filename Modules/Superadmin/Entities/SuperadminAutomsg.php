<?php

namespace Modules\Superadmin\Entities;

use Illuminate\Database\Eloquent\Model;

class SuperadminAutomsg extends Model
{

  protected $table = "superadmin_automsg";

    protected $guarded = ['id'];

    public static $TYPES = ['العملاء المتعاقدين', 'العملاء المحتملين', 'جميع العملاء'];

    public static $STATUS = [ 'مخفي ' ,' ظاهر'];

    
}
