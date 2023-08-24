<?php

namespace Modules\Superadmin\Http\Controllers;

use \Notification;
use App\System;
use App\Wallet;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\Subscription;
use Modules\Superadmin\Notifications\NewSubscriptionNotification;
use Modules\Superadmin\Entities\Package;
use Modules\Superadmin\Entities\SuperadminProduct;

class BaseController extends Controller
{

    /**
     * Returns the list of all configured payment gateway
     * @return Response
     */
    public function _payment_gateways()
    {
        $gateways = [];
        
        //Check if stripe is configured or not
        if (env('STRIPE_PUB_KEY') && env('STRIPE_SECRET_KEY')) {
            $gateways['stripe'] = 'Stripe';
        }

        //Check if paypal is configured or not
        if ((env('PAYPAL_SANDBOX_API_USERNAME') && env('PAYPAL_SANDBOX_API_PASSWORD')  && env('PAYPAL_SANDBOX_API_SECRET')) || (env('PAYPAL_LIVE_API_USERNAME') && env('PAYPAL_LIVE_API_PASSWORD')  && env('PAYPAL_LIVE_API_SECRET'))) {
            $gateways['paypal'] = 'PayPal';
        }

        //Check if Razorpay is configured or not
        if ((env('RAZORPAY_KEY_ID') && env('RAZORPAY_KEY_SECRET'))) {
            $gateways['razorpay'] = 'Razor Pay';
        }

        //Check if Pesapal is configured or not
        if ((config('pesapal.consumer_key') && config('pesapal.consumer_secret'))) {
            $gateways['pesapal'] = 'PesaPal';
        }

        //check if Paystack is configured or not
        $system = System::getCurrency();
        if (in_array($system->country, ['Nigeria', 'Ghana']) && (config('paystack.publicKey') && config('paystack.secretKey'))) {
            $gateways['paystack'] = 'Paystack';
        }
        
        //check if Flutterwave is configured or not
        if (env('FLUTTERWAVE_PUBLIC_KEY') && env('FLUTTERWAVE_SECRET_KEY') && env('FLUTTERWAVE_ENCRYPTION_KEY')) {
            $gateways['flutterwave'] = 'Flutterwave';
        }
        
        // check if offline payment is enabled or not
        $is_offline_payment_enabled = System::getProperty('enable_offline_payment');

        if ($is_offline_payment_enabled) {
            $gateways['offline'] = 'Offline';
        }

        $wallet= Wallet::where('business_id', session('business.id'))->first();
        if ($wallet) {
          $gateways['wallet'] = 'wallet';
      }
        return $gateways;
    }

    /**
     * Enter details for subscriptions
     * @return object
     */
    public function _add_subscription($business_id, $package, $gateway, $payment_transaction_id, $user_id, $is_superadmin = false)
    {
        if (!is_object($package)) {
            $package = Package::active()->find($package);
        }

        $subscription = ['business_id' => $business_id,
                        'package_id' => $package->id,
                        'paid_via' => $gateway,
                        'payment_transaction_id' => $payment_transaction_id
                    ];

        if ($package->price != 0 && (in_array($gateway, ['offline', 'pesapal']) && !$is_superadmin)) {
            //If offline then dates will be decided when approved by superadmin
            $subscription['start_date'] = null;
            $subscription['end_date'] = null;
            $subscription['trial_end_date'] = null;
            $subscription['status'] = 'waiting';
        } else {
            $dates = $this->_get_package_dates($business_id, $package);

            $subscription['start_date'] = $dates['start'];
            $subscription['end_date'] = $dates['end'];
            $subscription['trial_end_date'] = $dates['trial'];
            $subscription['status'] = 'approved';
        }
        
        $subscription['package_price'] = $package->price;
        $subscription['package_details'] = [
                'location_count' => $package->location_count,
                'warehouse_count' => $package->warehouse_count,
                'sup_warehouse' => $package->sup_warehouse,
                'sell_from_loation_main_store' => $package->sell_from_loation_main_store,
                'sell_from_store' => $package->sell_from_store,
                'enable_installment' => $package->enable_installment,
                'enable_invoice_url' => $package->enable_invoice_url,
                'enable_invoice_url_in_prient' => $package->enable_invoice_url_in_prient,
                'enable_qr_in_prient' => $package->enable_qr_in_prient,
                'enable_notice_forms' => $package->enable_notice_forms,
                'sleep_page_time' => $package->sleep_page_time,
                'user_count' => $package->user_count,
                'product_count' => $package->product_count,
                'invoice_count' => $package->invoice_count,
                'name' => $package->name
            ];

            //get all products from supperadminProduct
            $products = SuperadminProduct::latest()->pluck('code')->toArray();
            foreach ($products as $key=>$code){
              $subscription['package_details']["$code"] = 0;
            }
           
            // dd($subscription['package_details']);
        //Custom permissions.
        if (!empty($package->custom_permissions)) {
            foreach ($package->custom_permissions as $name => $value) {
                $subscription['package_details'][$name] = $value;
            }
        }
        
        $subscription['created_id'] = $user_id;
        $wallet = Wallet::where('business_id' ,$business_id)->first();
        
            
        if ($gateway == 'wallet') {
          if (!empty($wallet) && ($wallet->amount >= $package->price)) {
            $subscription = Subscription::create($subscription);
        
            if (!$is_superadmin) {
                $email = System::getProperty('email');
                $is_notif_enabled = System::getProperty('enable_new_subscription_notification');
    
                if (!empty($email) && $is_notif_enabled == 1) {
                    Notification::route('mail', $email)
                    ->notify(new NewSubscriptionNotification($subscription));
                }
            }
            $amount = $wallet->amount - $package->price;
            // dd($amount);
            $wallet->update(['amount'=> $wallet->amount - $package->price]);
    
            return $subscription;
          }else{
            return false;
          }
        }
       
        $subscription = Subscription::create($subscription);
        
        if (!$is_superadmin) {
            $email = System::getProperty('email');
            $is_notif_enabled = System::getProperty('enable_new_subscription_notification');

            if (!empty($email) && $is_notif_enabled == 1) {
                Notification::route('mail', $email)
                ->notify(new NewSubscriptionNotification($subscription));
            }
        }

        return $subscription;
    }

    /**
     * The function returns the start/end/trial end date for a package.
     *
     * @param int $business_id
     * @param object $package
     *
     * @return array
     */
    protected function _get_package_dates($business_id, $package)
    {
        $output = ['start' => '', 'end' => '', 'trial' => ''];

        //calculate start date
        $start_date = Subscription::end_date($business_id);
        $output['start'] = $start_date->toDateString();

        //Calculate end date
        if ($package->interval == 'days') {
            $output['end'] = $start_date->addDays($package->interval_count)->toDateString();
        } elseif ($package->interval == 'months') {
            $output['end'] = $start_date->addMonths($package->interval_count)->toDateString();
        } elseif ($package->interval == 'years') {
            $output['end'] = $start_date->addYears($package->interval_count)->toDateString();
        }
        
        $output['trial'] = $start_date->addDays($package->trial_days);

        return $output;
    }
}
