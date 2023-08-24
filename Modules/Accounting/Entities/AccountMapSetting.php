<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class AccountMapSetting extends Model
{
    protected $fillable = [
        'business_id',
        'chart_account_id',
        'name',
        'is_sell',
        'is_purchase',
        'is_salaries',
        'is_expenses',
        'is_customer_payments',
        'is_supplier_payments',
        'is_sell_paid',
        'is_purchase_paid',
        'is_expenses_paid',
        'is_expenses_return',
        'is_expenses_return_paid',
        'is_customer_payments_debit',
        'is_supplier_payments_debit',
        'is_salaries_paid',
        'type',
        'created_at',
        'updated_at',
    ];


    public function business(){
      return $this->belongsTo(Business::class ,'business_id','id');
    }

    public function chartAccount(){
      return $this->belongsTo(ChartOfAccount::class , 'chart_account_id' ,'id');
    }
  }
