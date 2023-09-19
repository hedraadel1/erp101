<?php

namespace Modules\Superadmin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Superadmin\Entities\ServerSubscriptions;
use Modules\Superadmin\Entities\ServerType;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Utils\BusinessUtil;

use App\System;


class SerSuperadminSubscriptionsController extends BaseController
{
  protected $businessUtil;

  /**
   * Constructor
   *
   * @param BusinessUtil $businessUtil
   * @return void
   */
  public function __construct(BusinessUtil $businessUtil)
  {
    $this->businessUtil = $businessUtil;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      $superadmin_Sersubscription = ServerSubscriptions::join('business', 'server_subscriptions.business_id', '=', 'business.id')
        ->join('server_types', 'server_subscriptions.server_types_id', '=', 'server_types.id')
        ->select('business.name as business_name', 'server_types.server_name as server_name', 'server_subscriptions.status', 'server_subscriptions.start_date', 'server_subscriptions.trial_end_date', 'server_subscriptions.end_date', 'server_subscriptions.server_types_price', 'server_subscriptions.paid_via', 'server_subscriptions.payment_transaction_id', 'server_subscriptions.id');

      return DataTables::of($superadmin_Sersubscription)
        ->addColumn(
          'action',
          '<button data-href ="{{action(\'\Modules\Superadmin\Http\Controllers\SerSuperadminSubscriptionsController@edit\',[$id])}}" class="btn btn-info btn-xs change_status" data-toggle="modal" data-target="#statusModal">
                            @lang( "superadmin::lang.status")
                            </button> <button data-href ="{{action(\'\Modules\Superadmin\Http\Controllers\SerSuperadminSubscriptionsController@editSubscription\',["id" => $id])}}" class="btn btn-primary btn-xs btn-modal" data-container=".view_modal">
                            @lang( "messages.edit")
                            </button>'
        )
        ->editColumn('trial_end_date', '@if(!empty($trial_end_date)){{@format_date($trial_end_date)}} @endif')
        ->editColumn('start_date', '@if(!empty($start_date)){{@format_date($start_date)}}@endif')
        ->editColumn('end_date', '@if(!empty($end_date)){{@format_date($end_date)}}@endif')
        ->editColumn(
          'status',
          '@if($status == "approved")
                            <div style="background:green;color:white;" class="odd"></div>
                            
                            <span class="label bg-light-green">{{__(\'superadmin::lang.\'.$status)}}
                                </span>
                            @elseif($status == "waiting")
                                <span class="label bg-aqua">{{__(\'superadmin::lang.\'.$status)}}
                                </span>
                            @else($status == "declined")
                                <span class="label bg-red">{{__(\'superadmin::lang.\'.$status)}}
                                </span>
                            @endif'
        )
        ->editColumn(
          'server_types_price',
          '<span class="display_currency" data-currency_symbol="true">
                                {{$server_types_price}}
                            </span>'
        )
        ->removeColumn('id')
        ->rawColumns([2, 6, 9])
        ->make(false);
    }
    return view('superadmin::SerSuperSubscriptions.index');
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    $business_id = request()->input('business_id');
    $servertype = ServerType::active()->orderby('created_at')->pluck('server_name', 'id');

    $gateways = $this->_payment_gateways();

    return view('superadmin::SerSuperSubscriptions.add_subscription')
      ->with(compact('servertype', 'business_id', 'gateways'));
  }

  /**
   * Store a newly created resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    if (!auth()->user()->can('subscribe')) {
      abort(403, 'Unauthorized action.');
    }

    try {
      DB::beginTransaction();

      $input = $request->only(['business_id', 'server_types_id', 'paid_via', 'payment_transaction_id']);

      $servertype = ServerType::find($input['server_types_id']);
      $user_id = $request->session()->get('user.id');
      $Sersubscription =  $this->_add_server_subscription($input['business_id'], $servertype, $input['paid_via'], $input['payment_transaction_id'], $user_id, true);

      $Sersubscription = ServerSubscriptions::create($Sersubscription);

      DB::commit();
      if ($Sersubscription) {
        $output = ['success' => true, 'msg' => __('lang_v1.success')];
      } else
        $output = ['success' =>   false, 'msg' => 'لا بوجد رصيد ف المحفظة'];
    } catch (\Exception $e) {
      DB::rollBack();

      \Log::emergency("File:" . $e->getFile() . " Line:" . $e->getLine() . "Message:" . $e->getMessage());

      $output = ['success' => 0, 'msg' => __('messages.something_went_wrong')];
    }

    return back()->with('status', $output);
  }

  /**
   * Show the specified resource.
   * @return Response
   */
  public function show()
  {
    return view('superadmin::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit($id)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      $status = ServerSubscriptions::server_subscription_status();
      $ServerSubscriptions = Server_Subscriptions::find($id);
      return view('superadmin::SerSuperSubscriptions.edit')
        ->with(compact('ServerSubscriptions', 'status'));
    }
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request, $id)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      try {
        $input = $request->only(['status', 'payment_transaction_id']);

        $Sersubscriptions = ServerSubscriptions::findOrFail($id);

        if ($Sersubscriptions->status != 'approved' && empty($Sersubscriptions->start_date) && $input['status'] == 'approved') {
          $dates = $this->_get_package_dates($Sersubscriptions->business_id, $Sersubscriptions->ServerType);
          $Sersubscriptions->start_date = $dates['start'];
          $Sersubscriptions->end_date = $dates['end'];
          $Sersubscriptions->trial_end_date = $dates['trial'];
        }

        $Sersubscriptions->status = $input['status'];
        $Sersubscriptions->payment_transaction_id = $input['payment_transaction_id'];
        $subscriptionsSersubscriptions->save();

        $output = array(
          'success' => true,
          'msg' => __("superadmin::lang.subcription_updated_success")
        );
      } catch (\Exception $e) {
        \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

        $output = array(
          'success' => false,
          'msg' => __("messages.something_went_wrong")
        );
      }
      return $output;
    }
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function destroy()
  {
  }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function editSubscription($id)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      $Sersubscriptions = ServerSubscriptions::find($id);

      return view('superadmin::SerSuperSubscriptions.edit_date_modal')
        ->with(compact('Sersubscriptions'));
    }
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function updateSubscription(Request $request)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      try {
        $input = $request->only(['start_date', 'end_date', 'trial_end_date']);

        $SerSuperSubscriptions = ServerSubscriptions::findOrFail($request->input('Sersubscriptions_id'));

        $SerSuperSubscriptions->start_date = !empty($input['start_date']) ? $this->businessUtil->uf_date($input['start_date']) : null;
        $SerSuperSubscriptions->end_date = !empty($input['end_date']) ? $this->businessUtil->uf_date($input['end_date']) : null;
        $SerSuperSubscriptions->trial_end_date = !empty($input['trial_end_date']) ? $this->businessUtil->uf_date($input['trial_end_date']) : null;
        $SerSuperSubscriptions->save();

        $output = array(
          'success' => true,
          'msg' => __("superadmin::lang.subcription_updated_success")
        );
      } catch (\Exception $e) {
        \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

        $output = array(
          'success' => false,
          'msg' => __("messages.something_went_wrong")
        );
      }
      return $output;
    }
  }
}