<?php

namespace Modules\ProductCatalogue\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Product;
use App\Business;
use App\Discount;
use App\SellingPriceGroup;
use App\Utils\ProductUtil;
use App\BusinessLocation;
use App\Cart;
use App\Utils\ModuleUtil;
use App\Category;
use App\Contact;
use App\TaxRate;
use App\User;
use App\Utils\BusinessUtil;
use App\Utils\ContactUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use App\Variation;
use App\VariationLocationDetails;
use Modules\Crm\Utils\CrmUtil;
use DB;
class CartController extends Controller
{

  protected $transactionUtil;
    protected $businessUtil;
    protected $commonUtil;
    protected $productUtil;
    protected $contactUtil;
    protected $crmUtil;
    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, BusinessUtil $businessUtil, Util $commonUtil, ProductUtil $productUtil, ContactUtil $contactUtil, CrmUtil $crmUtil)
    {
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->businessUtil = $businessUtil;
        $this->commonUtil = $commonUtil;
        $this->contactUtil = $contactUtil;
        $this->crmUtil = $crmUtil;
        $this->order_statuses = [
            'ordered' => [
                'label' => __('lang_v1.ordered'),
                'class' => 'bg-info'
            ],
            'partial' => [
                'label' => __('lang_v1.partial'),
                'class' => 'bg-yellow'
            ],
            'completed' => [
                'label' => __('restaurant.completed'),
                'class' => 'bg-green'
            ]
        ];
    }



    
  public function index(){
    $business_id = request()->session()->get('user.business_id');
    $business_details = $this->businessUtil->getDetails($business_id);
    $pos_settings = empty($business_details->pos_settings) ? $this->businessUtil->defaultPosSettings() : json_decode($business_details->pos_settings, true);
    $cart_data = $this->responseData();
    $products=[];
    $sub_units=[];

    $tax_dropdown = TaxRate::forBusinessDropdown($business_id, true, true);
    foreach ($cart_data['items'] as $item) {
     $product = $this->productUtil->getDetailsFromVariation($item->variation_id, $business_id, $item->location_id, false);
      if (!isset($product->quantity_ordered)) {
        $product->quantity_ordered = $item->quantity;
     }
      if (!isset($product->cart_id)) {
        $product->cart_id = $item->id;
     }
     $products[] =$product;
     $sub_units[] = $this->productUtil->getSubUnits($business_id, $product->unit_id, false, $product->product_id);

    }
    // dd($products);

    return view('productcatalogue::cart.index',compact('business_details','products' ,'tax_dropdown','cart_data'));
  }


    public function storeCart(Request $request)
    {
        // $output = [];

        try {
          $inputs = $request->cart;
            $product = VariationLocationDetails::where('product_id', $inputs['product_id'])->where('location_id', $inputs['location_id'])->first(); 
            // dd($product);
            $inputs['quantity'] = '1';
            $inputs['variation_id'] = $product->variation_id;

            if(!$this->storeDB($inputs, $product))
                return $this->errorResponse(null, [__('lang.msg_error_quantity', ['product' => optional($product->product)->name])], 422);
               
                $resultCheckout = $this->responseData();
           $res = [
                  // 'resultCheckout' => view($this->frontView('include.cart-down'), compact('resultCheckout'))->render(),
                  'items_count' => $resultCheckout['items_count']
              ];
              return $this->sendResponse($res, __('lang.products_added_to_cart'));
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output['success'] = false;
            $output['msg'] = "File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage();
        }

        return $output;
    }

    private function storeDB($inputs, $product)
    {
        $carts = Cart::where('user_id' , auth()->user()->id)->get();
        // dd($inputs);
        if(count($carts)) {
            // Get data from cart
            $cart = $carts->where('product_id', $inputs['product_id']);
            // Check Product Quantity in Stock
            if(($cart->sum('quantity') + $inputs['quantity']) > $product->qty_available) return false;
            $data = $cart->where('product_id', $inputs['product_id'])->first();

            // Check if existing data
            if($data) {
                $data->increment('quantity', $inputs['quantity']);
            } else {
                auth()->user()->cart()->create($inputs);
            }
        } else {
            // Add items to cart
            auth()->user()->cart()->create($inputs);
        }
        return true;
    }

    public function update(Request $request)
    {
      $business_id = request()->session()->get('user.business_id');

        // Update Products Cart
        $cartUpdate = $this->uodateDBCart(collect($request->all()['cart']));
        if(is_bool($cartUpdate) && ($cartUpdate == true)) {
            if(request()->ajax()) {
                $carts = $this->responseData();
                $products=[];
                $sub_units=[];
                foreach ($carts['items'] as $item) {
                  $product = $this->productUtil->getDetailsFromVariation($item->variation_id, $business_id, $item->location_id, false);
                    if (!isset($product->quantity_ordered)) {
                      $product->quantity_ordered = $item->quantity;
                  }
                    if (!isset($product->cart_id)) {
                      $product->cart_id = $item->id;
                  }
                  $products[] =$product;
                  $sub_units[] = $this->productUtil->getSubUnits($business_id, $product->unit_id, false, $product->product_id);

                }
                $res = [
                    'resultCheckout' => $products,
                    'items_count' => $carts['items_count']
                ];
                return $this->sendResponse($res, __('lang.products_updated_to_cart'));
            }
            $this->flash('success', __('lang.products_updated_to_cart'));
            return back();

        } else {
            if(request()->ajax()) {
                return $this->errorResponse(null, $cartUpdate, 422);
            }
            return back()->withErrors($cartUpdate);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrder(Request $request)
    {

        $is_direct_sale = true;

        try {
            $input = $request->except('_token');

            $input['status'] = 'ordered';
            $input['type'] = 'sales_order';
            $input['discount_amount'] = 0;
           
            $contact = Contact::where('business_id', auth()->user()->business_id)
            ->findOrFail(auth()->user()->crm_contact_id);
            $input['contact_id'] = $contact->id;
            if (!empty($input['products'])) {
                $business_id = $request->session()->get('user.business_id');
        
                $user_id = $request->session()->get('user.id');
                $invoice_total = $this->productUtil->calculateInvoiceTotal($input['products'], null);

                DB::beginTransaction();
                $input['transaction_date'] =  \Carbon::now();
                $input['is_direct_sale'] = 1;
                $input['location_id'] = auth()->user()->location_id;

                //Customer group details
                $contact_id = $contact->id;
                $cg = $this->contactUtil->getCustomerGroup($business_id, $contact_id);
                $input['customer_group_id'] = (empty($cg) || empty($cg->id)) ? null : $cg->id;

                //set selling price group id
                $price_group_id = $request->has('price_group') ? $request->input('price_group') : null;

                //If default price group for the location exists
                $price_group_id = $price_group_id == 0 && $request->has('default_price_group') ? $request->input('default_price_group') : $price_group_id;

                $input['selling_price_group_id'] = $price_group_id;

                $crm_settings = $this->crmUtil->getCrmSettings($business_id);
                $order_request_prefix = $crm_settings['order_request_prefix'] ?? null;

                $ref_count = $this->productUtil->setAndGetReferenceCount('crm_order_request');
                
                $input['invoice_no'] = $this->productUtil->generateReferenceNumber('crm_order_request', $ref_count, $business_id, $order_request_prefix);
                $transaction = $this->transactionUtil->createSellTransaction($business_id, $input, $invoice_total, $user_id);
                $transaction->crm_is_order_request = 1;
                $transaction->save();
                
                $this->transactionUtil->createOrUpdateSellLines($transaction, $input['products'], $input['location_id']);

                $this->transactionUtil->activityLog($transaction, 'added');
                Cart::where('user_id' , auth()->user()->id)->delete();
                DB::commit();

                $output = ['success' => 1, 'msg' => __('lang_v1.added_success') ];
            } else {
                $output = ['success' => 0,
                            'msg' => trans("messages.something_went_wrong")
                        ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            $msg = trans("messages.something_went_wrong");

            $output = ['success' => 0,
                            'msg' => $msg
                        ];
        }

        return redirect()
                ->action('\Modules\ProductCatalogue\Http\Controllers\ProductCatalogueController@index' ,[auth()->user()->business_id , auth()->user()->location_id])
                ->with('status', $output);

    }

     /**
     * Update Items Cart DB
     * @param $collection
     * @return bool
     */
    private function uodateDBCart($collection)
    {

        // Get Cart Data By Cart Id
        $carts = auth()->user()->cart()->with('product:id')->find($collection->pluck('cart_id'));
        // dd($carts);
        // Looping On Carts
        foreach ($carts->groupBy('product_id') as $key => $get) {
            // Get Total Qty From Cart & Request Inputs
            $totalQty = $collection->whereIn('cart_id', $get->pluck('id'))->sum('quantity');
            // Check If Total Qty Larger than Product Quantity
            // if($totalQty > $get->first()->product->quantity)
            //     $this->setErrorMsg(__('lang.msg_error_quantity', ['product' => $get->first()->product->title]));
        }
        // Check if count ErrorMsg larger than 0
        // if(count($this->getErrorMsg())) return false;
        // Update Cart Quantity in DB
        foreach ($carts as $get) {
            $get->update(['quantity' => $collection->firstWhere('cart_id', $get->id)['quantity']]);
        }
        return true;
    }


    private function responseData()
    {
        $carts = auth()->check() ? Cart::where('user_id',auth()->user()->id)->with('product')->get() : Cart::content();
        $mapping = $carts->map(function ($item) {
            $cost =  $item->price * $item->quantity;
            $item->product_total = sprintf('%0.2f', $cost);
            return $cost;
        });
        
        $data = [
            'items_count' => $carts->sum(auth()->check() ? 'quantity' : 'qty'),
            'sub_total' => number_format(array_sum($mapping->toArray()), 2, '.', ''),
            'items' => $carts
        ];
        return $data;
    }


    public function sendResponse($data, $message = null, $statusCode = null)
    {
        // Set array response data
        $response = [
            'status' => true,
            'message' => $message,
        ];
        // Set Data in Response Array
        $response['data'] = $data;
        // return response data
        return response()->json($response, $statusCode ?? 200);
    }

    public function errorResponse($error, $errorMessage = [], $code = 404)
    {
        // Set array response data
        $response = [
            'status' => false,
            'message' => $error
        ];

        // If not empty errors message => set item data in response array
        if(!empty($errorMessage)) {
            $response['errors'] = $errorMessage;
        }
        // dd($response);
        // return response data
        return response()->json($response, $code);
    }


    public function deleteItem(Request $request){
      $res =Cart::where('id',$request->id)->delete();
      return $this->sendResponse($res, __('lang.products_updated_to_cart'));
    }
}
