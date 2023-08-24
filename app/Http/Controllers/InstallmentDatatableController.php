<?php

namespace App\Http\Controllers;

use App\BusinessLocation;
use App\Contact;
use App\Transaction;
use App\User;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use app\Brands;
use DB;
use Illuminate\Http\Request;
use App\installment;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

class InstallmentDatatableController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $transactionUtil;
    protected $productUtil;
    protected $moduleUtil;
    protected $businessUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ProductUtil $productUtil, ModuleUtil $moduleUtil, BusinessUtil $businessUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;
        $this->moduleUtil = $moduleUtil;
        $this->businessUtil = $businessUtil;
    }

// public function getInstallmentsData()
// {
//   // Get totals for installments
        
// }
public function index(Request $request)
    {
        if ($request->ajax()) {
    /*         $installmets = installment::with('contact')->get(); */
            $business_id = request()->session()->get('user.business_id');
        /*  
            $installmets = installment::get()
                ->leftjoin(
                    'contacts as ic',
                    ' installment.contact_id',
                    '=',
                    'ic.id'
                )
               
                ->select(['ic.name as conname', 'installment_value', 'installment_duo_date', 'total_installment', '	status', 'id']);
 */       
                $installmets = DB::table('installment')
                ->leftJoin('contacts', 'installment.contact_id', '=', 'contacts.id')
           /* 
                ->leftjoin('business_locations as blo','installment.location_id','=','blo.id')
                /* ->select(['blo.name as bloname', 'installment_value', 'installment_duo_date', 'total_installment', 'status', 'id', 'name']); */

               ->get(); 
                
            return Datatables::of($installmets)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">دفع</a>';

                            return $btn;
                    })
                    
                    ->rawColumns(['action'])
                    ->editColumn('installment_value', function ($row) {
                        $html = '' . $this->transactionUtil->num_f($row->installment_value, true) . '';
        
                        return $html;
                    })
                    ->editColumn('total_installment', function ($row) {
                        $html = '' . $this->transactionUtil->num_f($row->total_installment, true) . '';
        
                        return $html;
                    })
                    ->make(true);
        }
      
        return view('installmentdetails.installmentDataTable');
    }

    public function getAllIns()
    {
        $business_id = request()->session()->get('user.business_id');
        $current_date = Carbon::now()->format('Y-m-d');
        $location = null;

        $installmets = installment::with('contact')->get();
            
        $contact = Contact::all();
        
       
        return view('installmentdetails.partials.AllInstallments', compact('installmets','contact'));

    }


    /**
     * Shows sales representative report
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllClientsReport(Request $request)
    {
        if (!auth()->user()->can('sales_representative.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        $users = User::allUsersDropdown($business_id, false);
        $business_locations = BusinessLocation::forDropdown($business_id, true);

        $business_details = $this->businessUtil->getDetails($business_id);
        $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);
    /*     $this->getAllIns(); */

    $current_date = Carbon::now()->format('Y-m-d');
    $location = null;

    $installmets = installment::with('contact')->get();
    $contact = Contact::all();

     // get installments data for statistics 
     $contactIds = DB::table('installment')
     ->select('contact_id')
     ->distinct()
     ->get();
     
     $totalDistinctContactIds = count($contactIds);
     // return $totalDistinctContactIds;


     // Get all the paid installments
       $paidInstallments = DB::table('installment')
       ->where('status', '=', 1)
       ->get();
       $paidInstallmentsTotalCount = count($paidInstallments);

       // Get the total amount of the paid insttalments
       $totalPaidInstallments = DB::table('installment')
       ->where('status', '=', 1)
       ->sum('installment_value');

       // Get the total amount of the unpaid insttalments
       $totalUnpaidInstallments = DB::table('installment')
       ->where('status', '=', 0)
       ->sum('installment_value');

       // Get all the paid installments
       $unpaidInstallments = DB::table('installment')
       ->where('status', '=', 0)
       ->get();
       $unpaidInstallmentsTotalCount = count($unpaidInstallments);


       // Get total count of unpaid due installments
       $unpaidDueInstallments = DB::table('installment')
     ->where('installment_duo_date', '<', $current_date)
     ->where('status', '=', 0)->get();

     $unpaidDueInstallmentsAmount = DB::table('installments')
            ->where('installment_duo_date', '<', now())
            ->where('status', '=', 0)
            ->sum('installment_value');
     
     $unpaidDueInstallmentsCount = count($unpaidDueInstallments);
     // return $unpaidDueInstallmentsCount;

     //Get the total amount of due unpaid
     $dueUnpaidTotalAmount = DB::table('installment')
      ->where('status', '=', 0)
      ->distinct('total_installment')
      ->sum('total_installment');
      $roundedTotal = round($dueUnpaidTotalAmount);

      // total of all installments 
      $total = DB::table('installment')
            ->distinct()
            ->sum('total_installment');

        return view('installmentdetails.installments')
            ->with(compact('users', 'business_locations', 'pos_settings','installmets', 'contact',
            'totalDistinctContactIds',
            'paidInstallmentsTotalCount',
            'unpaidDueInstallmentsAmount',
            'totalPaidInstallments',
            'totalUnpaidInstallments',
           'unpaidInstallmentsTotalCount',
           'unpaidDueInstallments',
          'unpaidDueInstallmentsCount',
          'roundedTotal',
        'total'));
    }


    /**
     * Shows sales representative total sales
     *
     * @return json
     */
    public function getSalesRepresentativeTotalSell(Request $request)
    {
        if (!auth()->user()->can('sales_representative.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        //Return the details in ajax call
        if ($request->ajax()) {
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            $location_id = $request->get('location_id');
            $created_by = $request->get('created_by');

            $sell_details = $this->transactionUtil->getSellTotals($business_id, $start_date, $end_date, $location_id, $created_by);

            //Get Sell Return details
            $transaction_types = [
                'sell_return'
            ];
            $sell_return_details = $this->transactionUtil->getTransactionTotals(
                $business_id,
                $transaction_types,
                $start_date,
                $end_date,
                $location_id,
                $created_by
            );

            $total_sell_return = !empty($sell_return_details['total_sell_return_exc_tax']) ? $sell_return_details['total_sell_return_exc_tax'] : 0;
            $total_sell = $sell_details['total_sell_exc_tax'] - $total_sell_return;

            return [
                'total_sell_exc_tax' => $sell_details['total_sell_exc_tax'],
                'total_sell_return_exc_tax' => $total_sell_return,
                'total_sell' => $total_sell
            ];
        }
    }



    public function activityLog()
    {
        $business_id = request()->session()->get('user.business_id');
        $transaction_types = [
            'contact' => __('report.contact'),
            'user' => __('report.user'),
            'sell' => __('sale.sale'),
            'purchase' => __('lang_v1.purchase'),
            'sales_order' => __('lang_v1.sales_order'),
            'purchase_order' => __('lang_v1.purchase_order'),
            'sell_return' => __('lang_v1.sell_return'),
            'purchase_return' => __('lang_v1.purchase_return'),
            'sell_transfer' => __('lang_v1.stock_transfer'),
            'stock_adjustment' => __('stock_adjustment.stock_adjustment'),
            'expense' => __('lang_v1.expense')
        ];

        if (request()->ajax()) {
            $activities = Activity::with(['subject'])
                ->leftjoin('users as u', 'u.id', '=', 'activity_log.causer_id')
                ->where('activity_log.business_id', $business_id)
                ->select(
                    'activity_log.*',
                    DB::raw("CONCAT(COALESCE(u.surname, ''), ' ', COALESCE(u.first_name, ''), ' ', COALESCE(u.last_name, '')) as created_by")
                );

            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $activities->whereDate('activity_log.created_at', '>=', $start)
                    ->whereDate('activity_log.created_at', '<=', $end);
            }

            if (!empty(request()->user_id)) {
                $activities->where('causer_id', request()->user_id);
            }

            $subject_type = request()->subject_type;
            if (!empty($subject_type)) {
                if ($subject_type == 'contact') {
                    $activities->where('subject_type', 'App\Contact');
                } else if ($subject_type == 'user') {
                    $activities->where('subject_type', 'App\User');
                } else if (in_array($subject_type, [
                    'sell', 'purchase',
                    'sales_order', 'purchase_order', 'sell_return', 'purchase_return', 'sell_transfer', 'expense', 'purchase_order'
                ])) {
                    $activities->where('subject_type', 'App\Transaction');
                    $activities->whereHasMorph('subject', Transaction::class, function ($q) use ($subject_type) {
                        $q->where('type', $subject_type);
                    });
                }
            }

            $sell_statuses = Transaction::sell_statuses();
            $sales_order_statuses = Transaction::sales_order_statuses(true);
            $purchase_statuses = $this->transactionUtil->orderStatuses();
            $shipping_statuses = $this->transactionUtil->shipping_statuses();

            $statuses = array_merge($sell_statuses, $sales_order_statuses, $purchase_statuses);
            return Datatables::of($activities)
                ->editColumn('created_at', '{{@format_datetime($created_at)}}')
                ->addColumn('subject_type', function ($row) use ($transaction_types) {
                    $subject_type = '';
                    if ($row->subject_type == 'App\Contact') {
                        $subject_type = __('contact.contact');
                    } else if ($row->subject_type == 'App\User') {
                        $subject_type = __('report.user');
                    } else if ($row->subject_type == 'App\Transaction' && !empty($row->subject->type)) {
                        $subject_type = isset($transaction_types[$row->subject->type]) ? $transaction_types[$row->subject->type] : '';
                    } elseif (($row->subject_type == 'App\TransactionPayment')) {
                        $subject_type = __('lang_v1.payment');
                    }
                    return $subject_type;
                })
                ->addColumn('note', function ($row) use ($statuses, $shipping_statuses) {
                    $html = '';
                    if (!empty($row->subject->ref_no)) {
                        $html .= __('purchase.ref_no') . ': ' . $row->subject->ref_no . '<br>';
                    }
                    if (!empty($row->subject->invoice_no)) {
                        $html .= __('sale.invoice_no') . ': ' . $row->subject->invoice_no . '<br>';
                    }
                    if ($row->subject_type == 'App\Transaction' && !empty($row->subject) && in_array($row->subject->type, ['sell', 'purchase'])) {
                        $html .= view('sale_pos.partials.activity_row', ['activity' => $row, 'statuses' => $statuses, 'shipping_statuses' => $shipping_statuses])->render();
                    } else {
                        $update_note = $row->getExtraProperty('update_note');
                        if (!empty($update_note) && !is_array($update_note)) {
                            $html .= $update_note;
                        }
                    }

                    if ($row->description == 'contact_deleted') {
                        $html .= $row->getExtraProperty('supplier_business_name') ?? '';
                        $html .= '<br>';
                    }

                    if (!empty($row->getExtraProperty('name'))) {
                        $html .= __('user.name') . ': ' . $row->getExtraProperty('name') . '<br>';
                    }

                    if (!empty($row->getExtraProperty('id'))) {
                        $html .= 'id: ' . $row->getExtraProperty('id') . '<br>';
                    }
                    if (!empty($row->getExtraProperty('invoice_no'))) {
                        $html .= __('sale.invoice_no') . ': ' . $row->getExtraProperty('invoice_no');
                    }

                    if (!empty($row->getExtraProperty('ref_no'))) {
                        $html .= __('purchase.ref_no') . ': ' . $row->getExtraProperty('ref_no');
                    }

                    return $html;
                })
                ->filterColumn('created_by', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(surname, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) like ?", ["%{$keyword}%"]);
                })
                ->editColumn('description', function ($row) {
                    return __('lang_v1.' . $row->description);
                })
                ->rawColumns(['note'])
                ->make(true);
        }

        $users = User::allUsersDropdown($business_id, false);

        return view('report.activity_log')->with(compact('users', 'transaction_types'));
    }
}
