<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Business;
use App\BusinessLocation;
use App\SettingGoFast;
use App\StaticsMsg;
use App\User;
use App\Utils\TransactionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Modules\Superadmin\Entities\SuperadminAutomsg;
use Yajra\DataTables\Facades\DataTables;

class WhatsappNotificationController extends BaseController
{

  public $transactionUtil;
  public function __construct(TransactionUtil $transactionUtil)
  {
    $this->transactionUtil = $transactionUtil;
  }


  public function index()
  {
    if (request()->ajax()) {
      $menus = SuperadminAutomsg::latest()->get();
      return DataTables::of($menus)
        ->addColumn(
          'action',
          function ($row) {
            $checked = $row->is_active == 1 ? 'checked' : '';
            return '
                      <a role="button" data-href="' . action('\Modules\Superadmin\Http\Controllers\WhatsappNotificationController@edit', $row->id) . '" class="btn Btn-Brand Btn-Primary btn-sm btn-modal" data-container=".whatsapp_notifications"><i class="glyphicon glyphicon-edit"></i>' . __("messages.edit") . '</a>
                      &nbsp;
                      <label class="switch">
                        <input type="checkbox" ' . $checked . ' data-id="' . $row->id . '"data-status=" ' . $row->is_active . ' " class="btn btn-sm Btn-Brand btn-info status_whatsapp_notifications_button">
                        <span class="slider round"></span>
                      </label>
                      &nbsp;
                      <button data-href="' . action('\Modules\Superadmin\Http\Controllers\WhatsappNotificationController@destroy', $row->id) . '" class="btn btn-sm Btn-Brand btn-danger delete_whatsapp_notifications_button"><i class="glyphicon glyphicon-trash"></i> ' . __("messages.delete") . '</button>';
          }
        )
        ->editColumn('msg_to', function ($row) {
          return SuperadminAutomsg::$TYPES[$row->msg_to];
        })
        ->editColumn('is_active', function ($row) {
          return SuperadminAutomsg::$STATUS[$row->is_active];
        })
        ->rawColumns(['action', 'msg_details'])
        ->make(true);
    }
    return view('superadmin::whatsapp_notifications.index');
  }


  public function create()
  {
    $automsg = new SuperadminAutomsg();
    $types = SuperadminAutomsg::$TYPES;
    return view('superadmin::whatsapp_notifications.form', compact('automsg', 'types'));
  }


  public function show()
  {
  }
  public function store(Request $request)
  {
    $inputs = $request->all();
    try {
      // dd($inputs);
      SuperadminAutomsg::create($inputs);
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

  public function edit($id)
  {
    $automsg = SuperadminAutomsg::findOrFail($id);
    $types = SuperadminAutomsg::$TYPES;
    return view('superadmin::whatsapp_notifications.form', compact('automsg', 'types'));
  }

  public function update(Request $request, $id)
  {
    $inputs = $request->all();
    try {
      $menu =  SuperadminAutomsg::findOrFail($id);
      $menu->update($inputs);
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


  public function destroy($id)
  {
    if (request()->ajax()) {
      try {

        SuperadminAutomsg::findOrFail($id)->delete();
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
  public function toggleStatus(Request $request)
  {
    if (request()->ajax()) {
      try {
        $inputs = $request->all();
        $resource = SuperadminAutomsg::findOrFail($inputs['id']);
        $resource->is_active = $inputs['is_active'];
        $resource->save();
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

  public function checkWhatsappMessage()
  {
    $business_paid = Business::where('is_paid', 1)->get();
    $business_not_paid = Business::where('is_paid', 0)->get();
    $all_busines = Business::get();

    $messages = SuperadminAutomsg::where('is_active', 1)->latest()->get();
    if ($messages) {
      foreach ($messages as $msg) {
        if ($msg->msg_to == 0) {
          foreach ($business_paid as  $business) {
            $data = [
              'message' => $msg->msg_details,
              'business_id' => $business->id,
              'time' => $msg->msg_time
            ];
            $this->taskjob($data);
          }
        } elseif ($msg->msg_to == 1) {
          foreach ($business_not_paid as  $business) {
            $data = [
              'message' => $msg->msg_details,
              'business_id' => $business->id,
              'time' => $msg->msg_time

            ];
            $this->taskjob($data);
          }
        } else {
          foreach ($all_busines as  $business) {
            $data = [
              'message' => $msg->msg_details,
              'business_id' => $business->id,
              'time' => $msg->msg_time
            ];
            $this->taskjob($data);
          }
        }
      }
      info("checkWhatsappMessage is run");
      //  $this ->sendMessagemanual();
      $output = ['status' => 'success', 'message' => 'تم ارسال الرسائل'];
    }

    $this->checkWhatsappSettingActions();

    return   $output;
  }

  public function checkWhatsappmanual()
  {
    $this->sendMessagemanual();
    $output = ['status' => 'success', 'message' => 'تم ارسال الرسائل'];
    return   $output;
  }
  public function checkWhatsappSettingActions()
  {
    $business_id = session('business.id');
    $setting_whatsapp_msgs = StaticsMsg::where('business_id', $business_id)->latest()->get();
    $location_ids = BusinessLocation::where('business_id', $business_id)->where('is_active', 1)->pluck('name', 'id')->toArray();
    $start = date('Y-m-d');
    $end = date('Y-m-d');

    if ($setting_whatsapp_msgs) {
      foreach ($location_ids as $location_id => $location_name) {
        foreach ($setting_whatsapp_msgs as $whatsapp_msg) {
          if ($whatsapp_msg->action_duration == 'week') {
            $end = \Carbon\Carbon::today()->subDays(7)->format('Y-m-d');
          }
          $report_total = $this->getTotals($location_id, $start, $end);
          // dd($location_name);
          $message = '';
          if ($whatsapp_msg->action_name == 'total_sells') {
            $message =  __('lang_v1.' . $whatsapp_msg->action_name) . '   اليوم بتاريخ    ' . date('Y-m-d H:i:s') . '   لفرع   ' . $location_name . '   بقيمة ' .  $report_total['total_sell'];
          }
          if ($whatsapp_msg->action_name == 'total_profits') {
            $message =  __('lang_v1.' . $whatsapp_msg->action_name) . '   اليوم بتاريخ :' . date('Y-m-d H:i:s') . '   لفرع   ' . $location_name . '   بقيمة ' .  $this->transactionUtil->num_f($report_total['net'], true);
          }
          if ($whatsapp_msg->action_name == 'total_purchases') {
            $message =  __('lang_v1.' . $whatsapp_msg->action_name) . '   اليوم بتاريخ :' . date('Y-m-d H:i:s') . '   لفرع   ' . $location_name . '   بقيمة ' .  $this->transactionUtil->num_f($report_total['total_purchase_exc_tax'], true);
          }
          if ($whatsapp_msg->action_name == 'total_expenses') {
            $message =  __('lang_v1.' . $whatsapp_msg->action_name) . '   اليوم بتاريخ :' . date('Y-m-d H:i:s') . '   لفرع   ' . $location_name . '   بقيمة ' .  $this->transactionUtil->num_f($report_total['total_expense'], true);
          }
          if ($whatsapp_msg->action_name == 'total_indebtedness_customer') {
            $message =  __('lang_v1.' . $whatsapp_msg->action_name) . '   اليوم بتاريخ :' . date('Y-m-d H:i:s') . '   لفرع   ' . $location_name . '   بقيمة ' .  $this->transactionUtil->num_f($report_total['invoice_due'], true);
          }
          if ($whatsapp_msg->action_name == 'total_indebtedness_customer') {
            $message =  __('lang_v1.' . $whatsapp_msg->action_name) . '   اليوم بتاريخ :' . date('Y-m-d H:i:s') . '   لفرع   ' . $location_name . '   بقيمة ' .  $this->transactionUtil->num_f($report_total['purchase_due'], true);
          }
          $data = [
            'message' => $message,
            'business_id' => $business_id,
            'time' => $whatsapp_msg->action_time,
          ];
          $date = Carbon::parse(Carbon::now());

          $day = $date->format('l');
          if ($whatsapp_msg->action_duration == 'week' && strtolower($day) == $whatsapp_msg->action_day) {
            $this->taskjob($data);
          } elseif ($whatsapp_msg->action_duration == 'daily') {
            $this->taskjob($data);
          }
        }
      }
    }



    return;
  }

  private function taskjob($data)
  {
    $item = DB::table('msg_task_job')->where('business_id', $data['business_id'])->where('time', $data['time'])->first();
    $time  = date('H:i:s');
    $diff =  Carbon::parse($data['time'])->diffInMinutes(Carbon::parse($time));
    if (!$item && $diff < 10) {
      DB::table('msg_task_job')->insert($data);
    }
    $this->sendMessage();
  }

  private  function sendMessage()
  {

    $msgs = DB::table('msg_task_job')->get();
    if ($msgs) {
      foreach ($msgs as $msg) {
        $user = User::where('business_id', $msg->business_id)->first();
        $res = $this->transactionUtil->sendNotificationWhatsapp($user->contact_number, $msg->message);
      }
    }
    DB::table('msg_task_job')->delete();
  }

  private  function sendMessagemanual()
  {
    $res = $this->transactionUtil->sendNotificationWhatsapptemplate('+201555520262');
    $msgs = DB::table('AutomsgContacts')->get();
    if ($msgs) {
      foreach ($msgs as $msg) {
        $res = $this->transactionUtil->sendNotificationWhatsapptemplate($msg->msgto);
      }
    }
    DB::table('AutomsgContacts')->delete();
  }



  /**
   * Retrieves purchase and sell details for a given time period.
   *
   * @return \Illuminate\Http\Response
   */
  private function getTotals($location_id, $start, $end)
  {
    if (request()->ajax()) {

      $business_id = request()->session()->get('user.business_id');

      $purchase_details = $this->transactionUtil->getPurchaseTotals($business_id, $start, $end, $location_id);

      $sell_details = $this->transactionUtil->getSellTotals($business_id, $start, $end, $location_id);

      $total_ledger_discount = $this->transactionUtil->getTotalLedgerDiscount($business_id, $start, $end);

      $purchase_details['purchase_due'] = $purchase_details['purchase_due'] - $total_ledger_discount['total_purchase_discount'];

      $transaction_types = [
        'purchase_return', 'sell_return', 'expense'
      ];

      $transaction_totals = $this->transactionUtil->getTransactionTotals(
        $business_id,
        $transaction_types,
        $start,
        $end,
        $location_id
      );

      $total_purchase_inc_tax = !empty($purchase_details['total_purchase_inc_tax']) ? $purchase_details['total_purchase_inc_tax'] : 0;
      $total_purchase_return_inc_tax = $transaction_totals['total_purchase_return_inc_tax'];

      $output = $purchase_details;
      $output['total_purchase'] = $total_purchase_inc_tax;
      $output['total_purchase_return'] = $total_purchase_return_inc_tax;

      $total_sell_inc_tax = !empty($sell_details['total_sell_inc_tax']) ? $sell_details['total_sell_inc_tax'] : 0;
      $total_sell_return_inc_tax = !empty($transaction_totals['total_sell_return_inc_tax']) ? $transaction_totals['total_sell_return_inc_tax'] : 0;

      $output['total_sell'] = $total_sell_inc_tax;
      $output['total_sell_return'] = $total_sell_return_inc_tax;

      $output['invoice_due'] = $sell_details['invoice_due'] - $total_ledger_discount['total_sell_discount'];
      $output['total_expense'] = $transaction_totals['total_expense'];

      //NET = TOTAL SALES - INVOICE DUE - EXPENSE
      $output['net'] = $output['total_sell'] - $output['invoice_due'] - $output['total_expense'];

      return $output;
    }
  }
}