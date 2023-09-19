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

class DepositRequestController extends BaseController
{

  public $transactionUtil;
    public function __construct(TransactionUtil $transactionUtil)
    {
      $this->transactionUtil = $transactionUtil;
    }


  public function index()
  {
    if (request()->ajax()) {
      $deposit_requests = DepositRequest::where('business_id', session('business.id'))->latest()->get();
        return DataTables::of($deposit_requests)
                ->addColumn(
                  'action',
                  function($row){
                    
                    $html ='';
                    if ($row->status == 'pending'){
                        $html .= '
                                <a role="button" data-href="'.action('\Modules\Superadmin\Http\Controllers\DepositRequestController@showImageModal', $row->id).'" class="btn Btn-Brand btn-info btn-sm btn-modal open_image_modal" data-container=".image-modal"><i class="glyphicon glyphicon-edit"></i> تحميل صورة</a>
                                &nbsp;
                              <button data-href="'.action('\Modules\Superadmin\Http\Controllers\DepositRequestController@destroy', $row->id).'" class="btn btn-sm Btn-Brand btn-danger delete_deposit_button"><i class="glyphicon glyphicon-trash"></i> الغاء الطلب</button>';
                      }
                  return $html;
                    }
                )
                ->editColumn('status', function ($row) {
                  $calss = $row->status == 'pending' ? 'bg-yellow' :($row->status == 'approved'? 'bg-green' :'bg-red');
                  return '<span class="label '.$calss.'">'.__('superadmin::lang.'.$row->status).'</span>';
                })
                ->editColumn('amount', function ($row) {
                  return $this->transactionUtil->num_f($row->amount ,true);
                })
                ->editColumn('image', function ($row) {
                  return '<img src="'.asset($row->image).'" style="width:50px">';
                })
                
                ->rawColumns(['action','status' ,'image'])
                ->make(true);
      }
      $payments = DepositRequest::$PAYMENT;
      return view('superadmin::deposit_requests.index',compact('payments'));
  }

  public function getAllDepositRequests()
  {
    if (request()->ajax()) {
      $deposit_requests = DepositRequest::where('business_id', session('business.id'))->get();
        return DataTables::of($deposit_requests)
                ->addColumn(
                  'action',
                  function($row){
                    $html ='<div style"display: flex !important;">';
                    if ($row->status == 'pending'){
                        $html .= '<a title="موافقة"   class="btn Btn-Brand btn-success btn-sm approved_request" data-id="'.$row->id.'" ><i class="fas fa-check"></i> </a>
                                &nbsp;
                                <a title="عرض الصورة" target="_blank" href="'. asset($row->image).'" class="btn Btn-Brand Btn-Primary btn-sm " ><i class="fas fa-eye"></i> </a>
                                &nbsp;
                                <a download title="تحميل الصورة" href="'. asset($row->image).'" class="btn Btn-Brand btn-info btn-sm " ><i class="fas fa-download"></i>  </a>
                                &nbsp;
                              <button title="رفض الطلب" data-href="'.action('\Modules\Superadmin\Http\Controllers\DepositRequestController@destroy', $row->id).'" class="btn btn-sm Btn-Brand btn-danger delete_deposit_button"><i class="glyphicon glyphicon-trash"></i> </button>';
                      }
                      $html .= '</div>';
                  return $html;
                    }
                )
                ->editColumn('status', function ($row) {
                  $calss = $row->status == 'pending' ? 'bg-yellow' :($row->status == 'approved'? 'bg-green' :'bg-red');
                  return '<span class="label '.$calss.'">'.__('superadmin::lang.'.$row->status).'</span>';
                })
                ->editColumn('amount', function ($row) {
                  return $this->transactionUtil->num_f($row->amount ,true);
                })
                ->editColumn('image', function ($row) {
                  return $row->image ?'تم رفع الصورة' :'لا توجد صورة';
                })
                ->addColumn('business_id', function ($row) {
                  return $row->business->id;
                })
                ->addColumn('business_name', function ($row) {
                  return $row->business->name;
                })
                ->addColumn('business_mobile', function ($row) {
                  return optional($row->business)->owner->contact_number;
                })
                
                ->rawColumns(['action','status' ,'image'])
              
                ->make(true);
      }
      $payments = DepositRequest::$PAYMENT;
      return view('superadmin::deposit_requests.all_deposit_requests',compact('payments'));
  }

  public function showImageModal($id)
  {
    $resource =  DepositRequest::findOrFail($id);
    return view('superadmin::deposit_requests.image_modal' ,compact('resource'));
  }
  
  public function store(Request $request)
  {
    
    try {
      DB::beginTransaction();
      $input = $request->all();
      DepositRequest::create($input);
      DB::commit();
      $admin = \App\User::where('username', env('ADMINISTRATOR_USERNAMES'))->first();
      $message = '  تم ارسال طلب ايداع جديد من خلال ' . session('business.name') . '   بقيمة' .$input['amount'];
      $this->transactionUtil->sendNotificationWhatsapp($admin->contact_number , $message );
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
  public function update(Request $request , $id)
  {
    $inputs = $request->except('image');
    $resource = DepositRequest::findOrFail($id);
    if($request->image){
      $inputs['image'] = uploadFile($request->image , 'uploads/superadmin/deposit_request/');
    }
    $resource->update($inputs);
      $admin = \App\User::where('username', env('ADMINISTRATOR_USERNAMES'))->first();
      $message = '  تم ارسال صورة  الايداع من خلال ' . session('business.name') ;
      $this->transactionUtil->sendNotificationWhatsapp($admin->contact_number , $message );
      
    $output = ['success' => true,'msg' => __('lang_v1.success')];

    return back()->with(['status' => $output]);

  }


  public function saveImage(Request $request)
  {
    $inputs = $request->except('image');
    $resource = DepositRequest::where('business_id',session('business.id'))->latest()->first();
    if($request->image){
      $inputs['image'] = uploadFile($request->image , 'uploads/superadmin/deposit_request/');
    }
    $resource->update($inputs);
      $admin = \App\User::where('username', env('ADMINISTRATOR_USERNAMES'))->first();
      $message = '  تم ارسال صورة  الايداع من خلال ' . session('business.name') ;
      $this->transactionUtil->sendNotificationWhatsapp($admin->contact_number , $message );
      
    $output = ['success' => true,'msg' => __('lang_v1.success')];

    return back()->with(['status' => $output]);

  }

  public function approvedDepositRequests(Request $request){
    try {
    $resource = DepositRequest::findOrFail($request->id);
    if($resource){
      $resource->status = DepositRequest::$STATUS['2'];
      $resource->save();
      $wallet = Wallet::where('business_id',$resource->business_id)->first();
      if ($wallet) {
        $wallet->amount = $wallet->amount + $resource->amount;
        $wallet->save();
      }else{
        Wallet::create([
          'amount' => $resource->amount,
          'business_id' => $resource->business_id,
        ]);
      }
      $output = ['success' => true,
      'msg' =>'تم شحن المحفظة بنجاح'
      ];
      $message = 'تم شحن المحفظة الخاصة بالنشاط بنجاح' ;
      $this->transactionUtil->sendNotificationWhatsapp(optional(optional($resource->business)->owner)->contact_number , $message );

    }
    }catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
  
      $output = ['success' => false,
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
          $output = ['success' => true,
                      'msg' => __("lang_v1.success")
                      ];
      } catch (\Exception $e) {
          \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
      
          $output = ['success' => false,
                      'msg' => __("messages.something_went_wrong")
                  ];
      }

      return $output;
    }
  }



  public function requestByCode(){
    $business_id = session('business.id');
    $codeIsExist = DB::table('business_code')->where('business_id',$business_id)->pluck('code')->toArray();
    $codes = DepositRequestCode::whereNotIn('code',$codeIsExist)->where('status' ,1)->pluck('code' , 'id')->toArray();
    return view('superadmin::deposit_requests.request_by_code_modal' , compact('codes'));
  }

  public function getCodeValue(Request $request){
    $item = DepositRequestCode::where('id',$request->code)->first();
    if($item)
    return response()->json(['value' => $this->transactionUtil->num_f($item->value,true)]);
    else
    return response()->json(['value' => '']);
  }

  public function requestPassCode(Request $request){
    try {
      $item = DepositRequestCode::where('id',$request->code)->first();
      DB::beginTransaction();
      $input =[
        'business_id' => session('business.id'),
        'amount' => $item->value,
        'status' => 'approved',
        'payment_method' => 'code',
      ];
     $resource = DepositRequest::create($input);
     $wallet = Wallet::where('business_id',$resource->business_id)->first();
     if ($wallet) {
       $wallet->amount = $wallet->amount + $resource->amount;
       $wallet->save();
     }else{
       Wallet::create([
         'amount' => $resource->amount,
         'business_id' => $resource->business_id,
       ]);
     }

     DB::table('business_code')->insert([
      'business_id' => $resource->business_id,
      'code' => $item->code,
     ]);
     $output = ['success' => true,
     'msg' =>'تم شحن المحفظة بنجاح'
     ];
      DB::commit();
      $admin = \App\User::where('username', env('ADMINISTRATOR_USERNAMES'))->first();
      $message = '  تم استخدام كود الشحن من خلال ' . session('business.name') . '   بقيمة' .$input['amount'];
      $this->transactionUtil->sendNotificationWhatsapp($admin->contact_number , $message );
     
      $message2 = 'تم شحن المحفظة الخاصة بالنشاط بنجاح' ;
      $this->transactionUtil->sendNotificationWhatsapp(optional(optional($resource->business)->owner)->contact_number , $message2 );

  } catch (\Exception $e) {
      DB::rollBack();
      \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
      
      $output = ['success' => 0, 'msg' => __('messages.something_went_wrong') ];
  }

  return back()->with('status', $output);
    

  }

}