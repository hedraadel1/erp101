<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category3 extends Model
{
    public $table = "category3";
 
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Return list of category2 for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($business_id, $show_none = false)
    {
        $query = Category3::where('business_id', $business_id);

        $category3 = $query->orderBy('name', 'asc')
                    ->pluck('name', 'id');

        if ($show_none) {
            $category3->prepend('جميع التصنيفات 3', '');
        }

        return $category3;
    }
}
