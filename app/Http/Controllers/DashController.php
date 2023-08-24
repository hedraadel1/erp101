<?php

namespace App\Http\Controllers;
use App\BusinessLocation;
use App\Charts\CommonChart;
use App\Currency;
use App\Transaction;
use App\Utils\BusinessUtil;
use App\installment;

use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use App\VariationLocationDetails;
use Datatables;
use DB;
use Illuminate\Http\Request;
use App\Utils\Util;
use App\Utils\RestaurantUtil;
use App\User;
use App\Contact;
use App\InvoiceBooking;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Carbon;
use App\Media;
use App\Product;
use App\SettingGoFast;
use App\Utils\ContactUtil;
use Modules\Superadmin\Entities\SuperadminProduct;

class DashController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $businessUtil;
    protected $transactionUtil;
    protected $moduleUtil;
    protected $commonUtil;
    protected $restUtil;
    protected $contactUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BusinessUtil $businessUtil,
        TransactionUtil $transactionUtil,
        ModuleUtil $moduleUtil,
        Util $commonUtil,
        RestaurantUtil $restUtil,
        ContactUtil $contactUtil

    ) {
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->commonUtil = $commonUtil;
        $this->restUtil = $restUtil;
        $this->contactUtil = $contactUtil;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
       
       
        $is_admin = $this->businessUtil->is_admin(auth()->user());

        if (!auth()->user()->can('dashboard.data')) {
            return view('home.index');
        }
        // dd($business_id);
        $fy = $this->businessUtil->getCurrentFinancialYear($business_id);

        $currency = Currency::where('id', request()->session()->get('business.currency_id'))->first();
        //ensure start date starts from at least 30 days before to get sells last 30 days
        $least_30_days = \Carbon::parse($fy['start'])->subDays(30)->format('Y-m-d');

        //get all sells
        $sells_this_fy = $this->transactionUtil->getSellsCurrentFy($business_id, $least_30_days, $fy['end']);
        
        $all_locations = BusinessLocation::forDropdown($business_id)->toArray();

        //Chart for sells last 30 days
        $labels = [];
        $all_sell_values = [];
        $dates = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = \Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;

            $labels[] = date('j M Y', strtotime($date));

            $total_sell_on_date = $sells_this_fy->where('date', $date)->sum('total_sells');

            if (!empty($total_sell_on_date)) {
                $all_sell_values[] = (float) $total_sell_on_date;
            } else {
                $all_sell_values[] = 0;
            }
        }

        //Group sells by location
        $location_sells = [];
        foreach ($all_locations as $loc_id => $loc_name) {
            $values = [];
            foreach ($dates as $date) {
                $total_sell_on_date_location = $sells_this_fy->where('date', $date)->where('location_id', $loc_id)->sum('total_sells');
                
                if (!empty($total_sell_on_date_location)) {
                    $values[] = (float) $total_sell_on_date_location;
                } else {
                    $values[] = 0;
                }
            }
            $location_sells[$loc_id]['loc_label'] = $loc_name;
            $location_sells[$loc_id]['values'] = $values;
        }

        $sells_chart_1 = new CommonChart;

        $sells_chart_1->labels($labels)
                        ->options($this->__chartOptions(__(
                            'home.total_sells',
                            ['currency' => $currency->code]
                            )));

        if (!empty($location_sells)) {
            foreach ($location_sells as $location_sell) {
                $sells_chart_1->dataset($location_sell['loc_label'], 'line', $location_sell['values']);
            }
        }

        if (count($all_locations) > 1) {
            $sells_chart_1->dataset(__('report.all_locations'), 'line', $all_sell_values);
        }

        $labels = [];
        $values = [];
        $date = strtotime($fy['start']);
        $last   = date('m-Y', strtotime($fy['end']));
        $fy_months = [];
        do {
            $month_year = date('m-Y', $date);
            $fy_months[] = $month_year;

            $labels[] = \Carbon::createFromFormat('m-Y', $month_year)
                            ->format('M-Y');
            $date = strtotime('+1 month', $date);

            $total_sell_in_month_year = $sells_this_fy->where('yearmonth', $month_year)->sum('total_sells');

            if (!empty($total_sell_in_month_year)) {
                $values[] = (float) $total_sell_in_month_year;
            } else {
                $values[] = 0;
            }
        } while ($month_year != $last);

        $fy_sells_by_location_data = [];

        foreach ($all_locations as $loc_id => $loc_name) {
            $values_data = [];
            foreach ($fy_months as $month) {
                $total_sell_in_month_year_location = $sells_this_fy->where('yearmonth', $month)->where('location_id', $loc_id)->sum('total_sells');
                
                if (!empty($total_sell_in_month_year_location)) {
                    $values_data[] = (float) $total_sell_in_month_year_location;
                } else {
                    $values_data[] = 0;
                }
            }
            $fy_sells_by_location_data[$loc_id]['loc_label'] = $loc_name;
            $fy_sells_by_location_data[$loc_id]['values'] = $values_data;
        }

        $sells_chart_2 = new CommonChart;
        $sells_chart_2->labels($labels)
                    ->options($this->__chartOptions(__(
                        'home.total_sells',
                        ['currency' => $currency->code]
                            )));
        if (!empty($fy_sells_by_location_data)) {
            foreach ($fy_sells_by_location_data as $location_sell) {
                $sells_chart_2->dataset($location_sell['loc_label'], 'line', $location_sell['values']);
            }
        }
        if (count($all_locations) > 1) {
            $sells_chart_2->dataset(__('report.all_locations'), 'line', $values);
        }

        //Get Dashboard widgets from module
        $module_widgets = $this->moduleUtil->getModuleData('dashboard_widget');

        $widgets = [];

        foreach ($module_widgets as $widget_array) {
            if (!empty($widget_array['position'])) {
                $widgets[$widget_array['position']][] = $widget_array['widget'];
            }
        }

        $common_settings = !empty(session('business.common_settings')) ? session('business.common_settings') : [];
        
        // task-4
        // get installment and contact data 
        $current_date = Carbon::now()->format('Y-m-d');
        $installmets=installment::with('contact')->where('status','0')
        ->where('installment_duo_date','<=',$current_date)->get();
        
        $business_locations = BusinessLocation::forDropdown($business_id, true);
        
        $contact = Contact::all();
        $this->getinstall();
        //get all products fron brand store
        $brand_store_products = SuperadminProduct::latest()->paginate(4);      

        return view('Dash.dash', compact('brand_store_products','sells_chart_1', 'sells_chart_2', 'widgets', 'business_locations','all_locations', 'common_settings', 'is_admin','installmets','contact'));
    }
    /*
    -task-4
    update insyallment date and status (0=>unpaid | 1=>paid) 
    */
    public function update_installment(Request $request){
        // dd($request);
        $paid=$request->paid==1?$request->paid:0;
        $installment=installment::find($request->installment_id);
        $installment->update([
            'status'=>'1',
            'installment_duo_date'=>$request->date,
        ]);
        return redirect()->route('home');
    }

    /**
     * Retrieves purchase and sell details for a given time period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotals()
    {
        if (request()->ajax()) {
            $start = request()->start;
            $end = request()->end;
            $location_id = request()->location_id;
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

    public function getinstallments(){
        $location_id = request()->location_id;
        $business_id = request()->session()->get('user.business_id');
        
    }

    /**
     * Retrieves sell products whose available quntity is less than alert quntity.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductStockAlert()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $query = VariationLocationDetails::join(
                'product_variations as pv',
                'variation_location_details.product_variation_id',
                '=',
                'pv.id'
            )
                    ->join(
                        'variations as v',
                        'variation_location_details.variation_id',
                        '=',
                        'v.id'
                    )
                    ->join(
                        'products as p',
                        'variation_location_details.product_id',
                        '=',
                        'p.id'
                    )
                    ->leftjoin(
                        'business_locations as l',
                        'variation_location_details.location_id',
                        '=',
                        'l.id'
                    )
                    ->leftjoin('units as u', 'p.unit_id', '=', 'u.id')
                    ->where('p.business_id', $business_id)
                    ->where('p.enable_stock', 1)
                    ->where('p.is_inactive', 0)
                    ->whereNull('v.deleted_at')
                    ->whereNotNull('p.alert_quantity')
                    ->whereRaw('variation_location_details.qty_available <= p.alert_quantity');

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('variation_location_details.location_id', $permitted_locations);
            }

            if (!empty(request()->input('location_id'))) {
                $query->where('variation_location_details.location_id', request()->input('location_id'));
            }

            $products = $query->select(
                'p.name as product',
                'p.type',
                'p.sku',
                'pv.name as product_variation',
                'v.name as variation',
                'v.sub_sku',
                'l.name as location',
                'variation_location_details.qty_available as stock',
                'u.short_name as unit'
            )
                    ->groupBy('variation_location_details.id')
                    ->orderBy('stock', 'asc');

            return Datatables::of($products)
                ->editColumn('product', function ($row) {
                    if ($row->type == 'single') {
                        return $row->product . ' (' . $row->sku . ')';
                    } else {
                        return $row->product . ' - ' . $row->product_variation . ' - ' . $row->variation . ' (' . $row->sub_sku . ')';
                    }
                })
                ->editColumn('stock', function ($row) {
                    $stock = $row->stock ? $row->stock : 0 ;
                    return '<span data-is_quantity="true" class="display_currency" data-currency_symbol=false>'. (float)$stock . '</span> ' . $row->unit;
                })
                ->removeColumn('sku')
                ->removeColumn('sub_sku')
                ->removeColumn('unit')
                ->removeColumn('type')
                ->removeColumn('product_variation')
                ->removeColumn('variation')
                ->rawColumns([2])
                ->make(false);
        }
    }

    /**
     * Retrieves payment dues for the purchases.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchasePaymentDues()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $today = \Carbon::now()->format("Y-m-d H:i:s");

            $query = Transaction::join(
                'contacts as c',
                'transactions.contact_id',
                '=',
                'c.id'
            )
                    ->leftJoin(
                        'transaction_payments as tp',
                        'transactions.id',
                        '=',
                        'tp.transaction_id'
                    )
                    ->where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'purchase')
                    ->where('transactions.payment_status', '!=', 'paid')
                    ->whereRaw("DATEDIFF( DATE_ADD( transaction_date, INTERVAL IF(transactions.pay_term_type = 'days', transactions.pay_term_number, 30 * transactions.pay_term_number) DAY), '$today') <= 7");

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('transactions.location_id', $permitted_locations);
            }

            if (!empty(request()->input('location_id'))) {
                $query->where('transactions.location_id', request()->input('location_id'));
            }

            $dues =  $query->select(
                'transactions.id as id',
                'c.name as supplier',
                'c.supplier_business_name',
                'ref_no',
                'final_total',
                DB::raw('SUM(tp.amount) as total_paid')
            )
                        ->groupBy('transactions.id');

            return Datatables::of($dues)
                ->addColumn('due', function ($row) {
                    $total_paid = !empty($row->total_paid) ? $row->total_paid : 0;
                    $due = $row->final_total - $total_paid;
                    return '<span class="display_currency" data-currency_symbol="true">' .
                    $due . '</span>';
                })
                ->addColumn('action', '@can("purchase.create") <a href="{{action("TransactionPaymentController@addPayment", [$id])}}" class="btn btn-xs btn-success add_payment_modal"><i class="fas fa-money-bill-alt"></i> @lang("purchase.add_payment")</a> @endcan')
                ->removeColumn('supplier_business_name')
                ->editColumn('supplier', '@if(!empty($supplier_business_name)) {{$supplier_business_name}}, <br> @endif {{$supplier}}')
                ->editColumn('ref_no', function ($row) {
                    if (auth()->user()->can('purchase.view')) {
                        return  '<a href="#" data-href="' . action('PurchaseController@show', [$row->id]) . '"
                                    class="btn-modal" data-container=".view_modal">' . $row->ref_no . '</a>';
                    }
                    return $row->ref_no;
                })
                ->removeColumn('id')
                ->removeColumn('final_total')
                ->removeColumn('total_paid')
                ->rawColumns([0, 1, 2, 3])
                ->make(false);
        }
    }

    /**
     * Retrieves payment dues for the purchases.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSalesPaymentDues()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $today = \Carbon::now()->format("Y-m-d H:i:s");

            $query = Transaction::join(
                'contacts as c',
                'transactions.contact_id',
                '=',
                'c.id'
            )
                    ->leftJoin(
                        'transaction_payments as tp',
                        'transactions.id',
                        '=',
                        'tp.transaction_id'
                    )
                    ->where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'sell')
                    ->where('transactions.payment_status', '!=', 'paid')
                    ->whereNotNull('transactions.pay_term_number')
                    ->whereNotNull('transactions.pay_term_type')
                    ->whereRaw("DATEDIFF( DATE_ADD( transaction_date, INTERVAL IF(transactions.pay_term_type = 'days', transactions.pay_term_number, 30 * transactions.pay_term_number) DAY), '$today') <= 7");

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('transactions.location_id', $permitted_locations);
            }

            if (!empty(request()->input('location_id'))) {
                $query->where('transactions.location_id', request()->input('location_id'));
            }

            $dues =  $query->select(
                'transactions.id as id',
                'c.name as customer',
                'c.supplier_business_name',
                'transactions.invoice_no',
                'final_total',
                DB::raw('SUM(tp.amount) as total_paid')
            )
                        ->groupBy('transactions.id');

            return Datatables::of($dues)
                ->addColumn('due', function ($row) {
                    $total_paid = !empty($row->total_paid) ? $row->total_paid : 0;
                    $due = $row->final_total - $total_paid;
                    return '<span class="display_currency" data-currency_symbol="true">' .
                    $due . '</span>';
                })
                ->editColumn('invoice_no', function ($row) {
                    if (auth()->user()->can('sell.view')) {
                        return  '<a href="#" data-href="' . action('SellController@show', [$row->id]) . '"
                                    class="btn-modal" data-container=".view_modal">' . $row->invoice_no . '</a>';
                    }
                    return $row->invoice_no;
                })
                ->addColumn('action', '@if(auth()->user()->can("sell.create") || auth()->user()->can("direct_sell.access")) <a href="{{action("TransactionPaymentController@addPayment", [$id])}}" class="btn btn-xs btn-success add_payment_modal"><i class="fas fa-money-bill-alt"></i> @lang("purchase.add_payment")</a> @endif')
                ->editColumn('customer', '@if(!empty($supplier_business_name)) {{$supplier_business_name}}, <br> @endif {{$customer}}')
                ->removeColumn('supplier_business_name')
                ->removeColumn('id')
                ->removeColumn('final_total')
                ->removeColumn('total_paid')
                ->rawColumns([0, 1, 2, 3])
                ->make(false);
        }
    }

    public function loadMoreNotifications()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'DESC')->paginate(10);

        if (request()->input('page') == 1) {
            auth()->user()->unreadNotifications->markAsRead();
        }
        $notifications_data = $this->commonUtil->parseNotifications($notifications);

        return view('layouts.partials.notification_list', compact('notifications_data'));
    }

    /**
     * Function to count total number of unread notifications
     *
     * @return json
     */
    public function getTotalUnreadNotifications()
    {
        $unread_notifications = auth()->user()->unreadNotifications;
        $total_unread = $unread_notifications->count();

        $notification_html = '';
        $modal_notifications = [];
        foreach ($unread_notifications as $unread_notification) {
            if (isset($data['show_popup'])) {
                $modal_notifications[] = $unread_notification;
                $unread_notification->markAsRead();
            }
        }
        if (!empty($modal_notifications)) {
            $notification_html = view('home.notification_modal')->with(['notifications' => $modal_notifications])->render();
        }

        return [
            'total_unread' => $total_unread,
            'notification_html' => $notification_html
        ];
    }

    private function __chartOptions($title)
    {
        return [
            'yAxis' => [
                    'title' => [
                        'text' => $title
                    ]
                ],
            'legend' => [
                'align' => 'right',
                'verticalAlign' => 'top',
                'floating' => true,
                'layout' => 'vertical'
            ],
        ];
    }

    public function getCalendar()
    {
        $business_id = request()->session()->get('user.business_id');
        $is_admin = $this->restUtil->is_admin(auth()->user(), $business_id);
        $is_superadmin = auth()->user()->can('superadmin');
        if (request()->ajax()) {
            $data = [
                'start_date' => request()->start,
                'end_date' => request()->end,
                'user_id' => ($is_admin || $is_superadmin) && !empty(request()->user_id) ? request()->user_id : auth()->user()->id,
                'location_id' => !empty(request()->location_id) ? request()->location_id : null,
                'business_id' => $business_id,
                'events' => request()->events ?? [],
                'color' => '#007FFF'
            ];
            $events = [];

            if (in_array('bookings', $data['events'])) {
                $events = $this->restUtil->getBookingsForCalendar($data);
            }
            
            $module_events = $this->moduleUtil->getModuleData('calendarEvents', $data);

            foreach ($module_events as $module_event) {
                $events = array_merge($events, $module_event);
            }  

            return $events;
        }

        $all_locations = BusinessLocation::forDropdown($business_id)->toArray();
        $users = [];
        if ($is_admin) {
            $users = User::forDropdown($business_id, false);
        }

        $event_types = [
            'bookings' => [
                'label' => __('restaurant.bookings'),
                'color' => '#007FFF'
            ]
        ];
        $module_event_types = $this->moduleUtil->getModuleData('eventTypes');
        foreach ($module_event_types as $module_event_type) {
            $event_types = array_merge($event_types, $module_event_type);
        }
        
        return view('home.calendar')->with(compact('all_locations', 'users', 'event_types'));
    }

    public function showNotification($id)
    {
        $notification = DatabaseNotification::find($id);

        $data = $notification->data;

        $notification->markAsRead();

        return view('home.notification_modal')->with([
                'notifications' => [$notification]
            ]);
    }

    public function attachMediasToGivenModel(Request $request)
    {   
        if ($request->ajax()) {
            try {
                
                $business_id = request()->session()->get('user.business_id');

                $model_id = $request->input('model_id');
                $model = $request->input('model_type');
                $model_media_type = $request->input('model_media_type');

                DB::beginTransaction();

                //find model to which medias are to be attached
                $model_to_be_attached = $model::where('business_id', $business_id)
                                        ->findOrFail($model_id);

                Media::uploadMedia($business_id, $model_to_be_attached, $request, 'file', false, $model_media_type);

                DB::commit();

                $output = [
                    'success' => true,
                    'msg' => __('lang_v1.success')
                ];
            } catch (Exception $e) {

                DB::rollBack();

                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong')
                ];
            }

            return $output;
        }
    }
    public function getinstall()
    {

        $business_id = request()->session()->get('user.business_id');
        $current_date = Carbon::now()->format('Y-m-d');
        $location = null;
       
        if (!empty($location_id)) {
            $location = BusinessLocation::where('business_id', $business_id)->find($location_id);
        }
        $location_id =  request()->location_id;
            if (!empty($location_id)) {
                $installmets=installment::with('contact')->where('status','0')
                ->where('installment_duo_date','<=',$current_date)->where('location_id', $location_id)->get();
            }
            else{
                $installmets=installment::with('contact')->where('status','0')
            ->where('installment_duo_date','<=',$current_date)->get();
            }
      
            $contact = Contact::all();
            return view('home.installment_modal') ->with(compact( 'location', 'installmets','contact')); 
        
    }
    public function getUserLocation($latlng)
    {
        $latlng_array = explode(',', $latlng);

        $response = $this->moduleUtil->getLocationFromCoordinates($latlng_array[0], $latlng_array[1]);

        return ['address' => $response];
    }


    public function getInvoiceBooking()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');

            $invoice_bookings_ids = InvoiceBooking::where('business_id', $business_id)
            ->where('status', 'pending')->pluck('invoice_id')->toArray();

            $query = Transaction::where('business_id', $business_id)
            ->whereIn('id',$invoice_bookings_ids)->with('contact','table')->latest();

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('location_id', $permitted_locations);
            }

            if (!empty(request()->input('location_id'))) {
                $query->where('location_id', request()->input('location_id'));
            }

            $transactions = $query->get();

            return Datatables::of($transactions)
            ->editColumn('contact_id', function(Transaction $transaction){
              $table_name = !empty($transaction->table) ? '-' .optional($transaction->table)->name  :'';
             return   $transaction->invoice_no .'('. optional($transaction->contact)->name .')' .$table_name;
                        
            })
            ->editColumn('location_id', function(Transaction $transaction){
             return   $transaction->location->name ;
                        
            })
            ->addColumn(
              'action',
              function (Transaction $transaction) {
                  $html = '<a href="#" data-href="' .action("SellController@show", [$transaction->id]) .'"class="btn-modal" data-container=".view_modal">
                  <span class="btn btn-info btn-sm"><i class="fas fa-eye" aria-hidden="true"></i> '.__('messages.view').'</span> 
                    </a>';
                  $html .='<a class="btn btn-success btn-sm"
                      href="'. action('SellPosController@confirmInvoiceBooking', [$transaction->id]) .'">
                      <i class="fas fa-pen " aria-hidden="true" title="تاكيد الحجز"></i> تاكيد الحجز
                      </a>';
                  $html .='<a class="btn btn-danger btn-sm"
                  href="'.action('SellPosController@cancelInvoiceBooking', [$transaction->id]) .'"><i
                      class="fas fa-undo"></i>
                  الغاء الحجز</a>';
                  return $html ;
              }
          )
          ->editColumn('transaction_date', '{{@format_datetime($transaction_date)}}')
          ->removeColumn('id')
          ->rawColumns(['action'])
          ->make(true);
        }
    }
    public function getMostProductSell()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $business_id = request()->session()->get('user.business_id');

            $query = DB::table('products')
            ->leftJoin('transaction_sell_lines','products.id','=','transaction_sell_lines.product_id')
            ->leftJoin('variation_location_details','products.id','=','variation_location_details.product_id')
            ->where('products.business_id',$business_id)
            ->selectRaw('products.*, COALESCE(sum(transaction_sell_lines.quantity),0) total , variation_location_details.location_id')
            ->groupBy('products.id')
            // ->take(5)
            ->orderBy('total','desc');
            
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('location_id', $permitted_locations);
            }

            if (!empty(request()->input('location_id'))) {
                $query->where('location_id', request()->input('location_id'));
            }
            $sales = $query->get();
          return Datatables::of($sales)
            ->editColumn('location_id' , function($row){
              $product = Product::findOrFail($row->id);
              return $product->getLocationName($row->location_id);
            })
          ->removeColumn('id')
          // ->rawColumns(['action'])
          ->make(true);
        }
    }


    public function globalSearch(Request $request){
      if(request()->ajax()) {
        // dd($request->all());
        $business_id = request()->session()->get('user.business_id');
        if ($request->search_type == 'all') {
        $data['users'] = $this->filterUsers($request,$business_id)->take(4);
        $data['customer'] = $this->filterCustomr($request , $business_id ,'customer')->take(4);
        $data['supplier'] =  $this->filterCustomr($request , $business_id ,'supplier')->take(4);
        $data['product'] =  $this->filterProduct($request , $business_id )->take(4);
        $data['sells'] =  $this->filterSell($request , $business_id )->take(4);
        $data['purchase'] =  $this->filterPurchase($request , $business_id )->take(4);

        }
        if ($request->search_type == 'users') {
        $data['users'] = $this->filterUsers($request,$business_id);
        }
        if ($request->search_type == 'customer') {
         $data['customer'] = $this->filterCustomr($request , $business_id ,'customer');
        }
        if ($request->search_type == 'suppliers') {
         $data['supplier'] =  $this->filterCustomr($request , $business_id ,'supplier');
        }
        if ($request->search_type == 'products') {
         $data['product'] =  $this->filterProduct($request , $business_id );
        }
        if ($request->search_type == 'sells') {
         $data['sells'] =  $this->filterSell($request , $business_id );
        }
        if ($request->search_type == 'purchase') {
         $data['purchase'] =  $this->filterPurchase($request , $business_id );
        }
       
        // dd($data);
      return view('layouts.partials.search_data', compact('data'));
    }
    }
                                                    
    private function filterCustomr($request , $business_id , $type){
      $search_fields = ['name' ,'mobile'];
      $query = $this->contactUtil->getContactQuery($business_id, $type);
     // ->where('contacts.name', 'like', '%' . $request->search . '%');
        $query->where(function ($query) use ($request, $search_fields) {

          if (in_array('name', $search_fields)) {
              $query->where('contacts.name', 'like', '%' . $request->search .'%');
          }

          if (in_array('mobile', $search_fields)) {
              $query->orWhere('contacts.mobile', 'like', '%' . $request->search .'%');
          }

      });
     return $query->latest()->get();
    }
    private function filterUsers($request ,$business_id){
      $search_fields = ['username' ,'first_name', 'email'];
      $query = User::where('business_id',$business_id)
      ->user()
      ->where('is_cmmsn_agnt', 0)
      ->where('username','!=', 'eleraqy');
        $query->where(function ($query) use ($request, $search_fields) {
          if (in_array('username', $search_fields)) {
              $query->where('username', 'like', '%' . $request->search .'%');
          }
          if (in_array('first_name', $search_fields)) {
              $query->orWhere('first_name', 'like', '%' . $request->search .'%');
          }
          if (in_array('email', $search_fields)) {
              $query->orWhere('email', 'like', '%' . $request->search .'%');
          }
          
      });
     return $query->latest()->get();
    }
    private function filterProduct($request,$business_id,$location_id=null){
      $search_fields = ['name' ,'sku', 'sub_sku' ,'category'];
      $search_term = $request->search;
      $query = Product::join('variations', 'products.id', '=', 'variations.product_id')
              ->active()
              ->whereNull('variations.deleted_at')
              ->leftjoin('units as U', 'products.unit_id', '=', 'U.id')
              ->leftjoin(
                'variation_location_details AS VLD',
                function ($join) use ($location_id) {
                    $join->on('variations.id', '=', 'VLD.variation_id');

                    //Include Location
                    if (!empty($location_id)) {
                        $join->where(function ($query) use ($location_id) {
                            $query->where('VLD.location_id', '=', $location_id);
                            //Check null to show products even if no quantity is available in a location.
                            //TODO: Maybe add a settings to show product not available at a location or not.
                            $query->orWhereNull('VLD.location_id');
                        });
                        ;
                    }
                }
            );
  
      $query->where('products.business_id', $business_id)
              ->where('products.type', '!=', 'modifier');

      //Search with like condition
      $query->where(function ($query) use ($search_term, $search_fields) {

          if (in_array('name', $search_fields)) {
              $query->where('products.name', 'like', '%' . $search_term .'%');
          }

          if (in_array('sku', $search_fields)) {
              $query->orWhere('sku', 'like', '%' . $search_term .'%');
          }

          if (in_array('sub_sku', $search_fields)) {
              $query->orWhere('sub_sku', 'like', '%' . $search_term .'%');
          }

          if (in_array('category', $search_fields)) {
            $query->orWhereHas('category', function ($q) use ($search_term){
              $q->where('name',  '%' . $search_term . '%');
           });
              // $query->orWhere('pl.lot_number', 'like', '%' . $search_term .'%');
          }

         
      });


      $query->select(
              'products.id as product_id',
              'products.name',
              'VLD.qty_available',
              'variations.sell_price_inc_tax as selling_price',
          );

      

      $query->groupBy('variations.id');
      return $query->orderBy('VLD.qty_available', 'desc')
      ->latest('variations.created_at')->get();
    }

    private function filterSell($request , $business_id ){
      $search_fields = ['contact' ,'invoice_no'];
      $query = $this->transactionUtil->getListSells($business_id, 'sell');;
     // ->where('contacts.name', 'like', '%' . $request->search . '%');
        $query->where(function ($query) use ($request, $search_fields) {

          if (in_array('invoice_no', $search_fields)) {
              $query->orWhere('transactions.invoice_no', 'like', '%' . $request->search .'%');
          }

          if (in_array('contact', $search_fields)) {
              $query->orWhere('contacts.name', 'like', '%' . $request->search .'%');
          }

      });
     return $query->get();
    }
    private function filterPurchase($request , $business_id ){
      $search_fields = ['contact' ,'ref_no'];
      $query  = $this->transactionUtil->getListPurchases($business_id);;
     // ->where('contacts.name', 'like', '%' . $request->search . '%');
        $query->where(function ($query) use ($request, $search_fields) {

          if (in_array('ref_no', $search_fields)) {
              $query->where('transactions.ref_no', 'like', '%' . $request->search .'%');
          }

          if (in_array('contact', $search_fields)) {
              $query->orWhere('contacts.name', 'like', '%' . $request->search .'%');
          }

      });
     return $query->get();
    }



    public function goFastSearch(Request $request){
    $items=[];
      if ($request->search) {
        $items = SettingGoFast::where('menu_name','like', '%' . $request->search .'%')->latest()->get();
      }
        return view('layouts.partials.go_fast', compact('items'));
      }

  
  }

