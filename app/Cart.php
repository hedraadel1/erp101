<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'product_id',
        'variation_id',
        'location_id',
        'price',
        'quantity',
      
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['cost','net_profit'];

    
    // Appending Cost Attribute
    public function getCostAttribute()
    {
        return  number_format($this->quantity * $this->product->after_discount_with_tax, 2, '.', '');
    }
    // public function getCostAttribute()
    // {
    //     return number_format($this->quantity * ($this->product->discount ? $this->product->after_discount : $this->product->price), 2, '.', '');
    // }

    // Appending Cost Items Attribute
    public function getCostItemsAttribute()
    {
        return number_format($this->quantity * ($this->product->discount_with_tax ? $this->product->after_discount_with_tax : $this->product->price_with_tax), 2, '.', '');
    }


    // Relations
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   
}
