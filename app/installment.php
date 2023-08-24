<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contact;

class installment extends Model
{
    // use HasFactory;k

    protected $table = "installment";
    protected $hidden = [];
    
    protected $fillable = [
        "id",
        "contact_id",
        "business_id",
        "location_id",
        "transaction_id",
        "total_installment",
        "installment_value",
        "installment_order",
        "installment_duo_date",
        "status",
        "notes",
        "created_at",
        "updated_at",
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class,'contact_id','id');
    }

}


