<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class WalletController extends BaseController
{
  public function index()
  {

  }
  public function create()
  {
      $business_id = request()->input('business_id');
      $type = request()->input('type');

      return view('superadmin::wallet.add_wallet')
            ->with(compact( 'business_id' ,'type'));
  }
  
  public function store(Request $request)
  {
    
    try {
      DB::beginTransaction();
      $input = $request->except('_token');
      $wallet = Wallet::where('business_id',$input['business_id'])->first();
      if ($wallet) {
       if (!empty($input['amount'])) {
         $total = $input['amount'] + $wallet->amount;
         $wallet->update(['amount' => $total]);

       } else {
          $total = $input['free_money'] + $wallet->free_money;
          $wallet->update(['free_money' => $total]);
       }
       
        
      } else {
          Wallet::create($input);
      }
      
      DB::commit();

      $output = ['success' => 1,
              'msg' => __('lang_v1.success')
          ];
  } catch (\Exception $e) {
      DB::rollBack();

      \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
      
      $output = ['success' => 0, 'msg' => __('messages.something_went_wrong') ];
  }

  return back()->with('status', $output);
    
  }
  public function show()
  {

  }
  public function edit()
  {

  }
  public function update()
  {

  }
  public function destroy()
  {

  }

}
