<?php

namespace Modules\Superadmin\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SuperadminProduct extends Model
{

    protected $table = "superadmin_products";

    protected $guarded = ['id'];

    protected $appends = ['image_url' , 'price_after_discount'];


      /**
     * Get the products image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!empty($this->image)) {
            $image_url = asset($this->image);
        } else {
            $image_url = asset('/img/default.png');
        }
        return $image_url;
    }

    public function getAllImagesAttribute()
    {
        $images = $this->product_media->pluck('media')->toArray();
        array_unshift($images, $this->image_url );
        return $images;
    }
      /**
     * Get the price_after_discount .
     *
     * @return string
     */
    public function getPriceAfterDiscountAttribute()
    {
      $price_after_discount = $this->price;
      if ($this->get_product_discount($this->id)) {
        if ($this->get_product_discount($this->id)->is_limited_offer == 1) {
          if(date('Y-m-d') <= $this->get_product_discount($this->id)->date_to){
            if ($this->get_product_discount($this->id)->type == 'fixed') {
            $price_after_discount = $this->price - $this->get_product_discount($this->id)->discount;
          }else{
            
            $price_after_discount =$this->price-(( $this->price * $this->get_product_discount($this->id)->discount) /100);  
          }
          }
          
        }else{
          if ($this->get_product_discount($this->id)->type == 'fixed') {
            $price_after_discount = $this->price - $this->get_product_discount($this->id)->discount;
          }else{
            
            $price_after_discount =$this->price-(( $this->price * $this->get_product_discount($this->id)->discount) /100);  
          }
        }
      }

        return $price_after_discount;
    }

    public function product_discount(){
      return $this->hasMany(SuperadminProductDiscount::class ,'product_id' , 'id' );
    }
    public function product_media(){
      return $this->hasMany(SuperadminProductMedia::class ,'product_id' , 'id' );
    }

    public function get_product_discount($id){
      return SuperadminProductDiscount::where('product_id',$id)->where('date_to', '>=',date('Y-m-d'))->latest()->first() ?? new SuperadminProductDiscount();
    }
}
