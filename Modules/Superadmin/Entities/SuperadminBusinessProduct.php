<?php

namespace Modules\Superadmin\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SuperadminBusinessProduct extends Model
{

  protected $table = "superadmin_business_products";

  protected $guarded = ['id'];



  public function product()
  {
    return $this->belongsTo(SuperadminProduct::class, 'product_id', 'id');
  }
}