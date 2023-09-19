<?php

namespace Modules\Superadmin\Http\Controllers;

use App\DepositRequest;
use App\DepositRequestCode;
use App\Utils\TransactionUtil;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Yajra\DataTables\Facades\DataTables;

class DepositRequestCodeController extends BaseController
{

  public $transactionUtil;
  public function __construct(TransactionUtil $transactionUtil)
  {
    $this->transactionUtil = $transactionUtil;
  }


  public function index()
  {
    if (request()->ajax()) {
      $deposit_requests = DepositRequestCode::latest()->get();
      return DataTables::of($deposit_requests)
        ->addColumn(
          'action',
          function ($row) {

            $html = '';
            $html .= '
                          <button data-id="' . $row->id . '"data-status=" ' . $row->status . ' " class="btn btn-sm Btn-Brand btn-info status_code_button"> تغيير الحالة</button>
                          &nbsp;
                          <a data-id="' . $row->id . '"data-status=" ' . $row->status . ' " class="btn btn-sm Btn-Brand btn-info status_code_button"> تغيير الحالة</button>
                          &nbsp;
                          <button data-href="' . action('\Modules\Superadmin\Http\Controllers\DepositRequestController@destroy', $row->id) . '" class="btn btn-sm Btn-Brand btn-danger delete_deposit_button"><i class="glyphicon glyphicon-trash"></i> الغاء الطلب</button>';

            return $html;
          }
        )
        ->editColumn('status', function ($row) {
          $calss = $row->status == 1 ? 'bg-green' : 'bg-red';
          $text = $row->status == 1 ? 'مفعل' : 'غير مفعل';
          return '<span class="label ' . $calss . '">' . $text . '</span>';
        })
        ->editColumn('value', function ($row) {
          return $this->transactionUtil->num_f($row->value, true);
        })


        ->rawColumns(['action', 'status'])
        ->make(true);
    }
    $payments = DepositRequest::$PAYMENT;
    return view('superadmin::deposit_requests.cods.index');
  }



  public function create()
  {
    $resource = new DepositRequestCode();
    return view('superadmin::deposit_requests.cods.form', compact('resource'));
  }

  public function store(Request $request)
  {

    try {
      DB::beginTransaction();
      $input = $request->all();
      $rand =  rand(0, 999999999999);
      $code = str_pad($rand, 12, '0', STR_PAD_LEFT);
      $input['code'] = empty($input['code']) ? $code : $input['code'];
      DepositRequestCode::create($input);
      DB::commit();
      $output = [
        'success' => 1,
        'msg' => __('lang_v1.success')
      ];
    } catch (\Exception $e) {
      DB::rollBack();
      \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      $output = ['success' => 0, 'msg' => __('messages.something_went_wrong')];
    }

    return  $output;
  }
  public function show()
  {
  }
  public function edit()
  {
  }
  public function update(Request $request, $id)
  {
    $inputs = $request->except('image');
    $resource = DepositRequest::findOrFail($id);
    if ($request->image) {
      $inputs['image'] = uploadFile($request->image, 'uploads/superadmin/deposit_request/');
    }
    $resource->update($inputs);
    $admin = \App\User::where('username', env('ADMINISTRATOR_USERNAMES'))->first();
    $message = '  تم ارسال صورة  الايداع من خلال ' . session('business.name');
    $this->transactionUtil->sendNotificationWhatsapp($admin->contact_number, $message);

    $output = ['success' => true, 'msg' => __('lang_v1.success')];

    return back()->with(['status' => $output]);
  }


  public function saveImage(Request $request)
  {
    $inputs = $request->except('image');
    $resource = DepositRequest::where('business_id', session('business.id'))->latest()->first();
    if ($request->image) {
      $inputs['image'] = uploadFile($request->image, 'uploads/superadmin/deposit_request/');
    }
    $resource->update($inputs);
    $admin = \App\User::where('username', env('ADMINISTRATOR_USERNAMES'))->first();
    $message = '  تم ارسال صورة  الايداع من خلال ' . session('business.name');
    $this->transactionUtil->sendNotificationWhatsapp($admin->contact_number, $message);

    $output = ['success' => true, 'msg' => __('lang_v1.success')];

    return back()->with(['status' => $output]);
  }

  public function approvedDepositRequests(Request $request)
  {
    try {
      $resource = DepositRequest::findOrFail($request->id);
      if ($resource) {
        $resource->status = DepositRequest::$STATUS['2'];
        $resource->save();
        $wallet = Wallet::where('business_id', $resource->business_id)->first();
        if ($wallet) {
          $wallet->amount = $wallet->amount + $resource->amount;
          $wallet->save();
        } else {
          Wallet::create([
            'amount' => $resource->amount,
            'business_id' => $resource->business_id,
          ]);
        }
        $output = [
          'success' => true,
          'msg' => 'تم شحن المحفظة بنجاح'
        ];
      }
    } catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

      $output = [
        'success' => false,
        'msg' => __("messages.something_went_wrong")
      ];
    }
    return $output;
  }

  public function destroy($id)
  {
    if (request()->ajax()) {
      try {

        $data =  DepositRequest::findOrFail($id);
        $data->status = DepositRequest::$STATUS['1'];
        $data->save();
        $output = [
          'success' => true,
          'msg' => __("lang_v1.success")
        ];
      } catch (\Exception $e) {
        \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

        $output = [
          'success' => false,
          'msg' => __("messages.something_went_wrong")
        ];
      }

      return $output;
    }
  }
}