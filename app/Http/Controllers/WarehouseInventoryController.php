<?php

namespace App\Http\Controllers;

use App\BusinessLocation;
use App\Product;
use App\Transaction;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use App\WarehouseInventory;
use App\WarehouseInventoryProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use DB;
class WarehouseInventoryController extends Controller
{
     /**
     * All Utils instance.
     *
     */
    protected $productUtil;
    protected $transactionUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil, TransactionUtil $transactionUtil, ModuleUtil $moduleUtil)
    {
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

      $business_id = request()->session()->get('user.business_id');
        if (request()->ajax()) {

            $warehouse_inventory = WarehouseInventory::where('business_id', $business_id)->get();                                

            return Datatables::of($warehouse_inventory)
                    ->addColumn(
                      'action',
                      function($row){
                        return '<button data-href="'.action('WarehouseInventoryController@show', $row->id).'" class="btn Btn-Brand Btn-bx btn-info warehouse_inventory_show" data-container=".warehouse_inventory_show"><i class="fa fa-eye"></i>'. __("messages.view").'</button>
                              &nbsp;
                        <a href="'.action('WarehouseInventoryController@edit', $row->id).'" class="btn Btn-Brand Btn-bx  btn-primary " ><i class="glyphicon glyphicon-edit"></i>'. __("messages.edit").'</a>
                            &nbsp;
                            <button data-href="'.action('WarehouseInventoryController@destroy', $row->id).'" class="btn Btn-Brand Btn-bx  btn-danger delete_warehouse_inventory_button"><i class="glyphicon glyphicon-trash"></i> '.__("messages.delete").'</button>';
                      }
                    )
                    ->editColumn('location_id', function($row){
                      return optional($row->location)->name;
                    })
                    ->removeColumn('id')
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $business_locations = BusinessLocation::forDropdownWithMainWarehouseAndSupWarehouse($business_id);
        $business_locations->prepend(__('lang_v1.none'), 'none');
        return view('warehouse_inventory.index' ,compact('business_locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $business_id = request()->session()->get('user.business_id');
      $location_id= $request->location_id;
      $products = Product::where('business_id', $business_id)
      ->join('variation_location_details', 'products.id', '=', 'variation_location_details.product_id')
      ->where('variation_location_details.location_id', $location_id)
     ->select(
      'products.name',
      'products.unit_id',
      'variation_location_details.*'
     )
      ->get();
      // dd($products);
  
        return view('warehouse_inventory.create' ,compact('location_id','products')); 
    }
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
          DB::beginTransaction();

            $input = $request->except('products');
            $input['date'] = !empty($input['date']) ?Carbon::parse($input['date'])->format('Y-m-d H:i:s') : date('Y-m-d H:i:s');
            $input['business_id'] = $request->session()->get('user.business_id');
            $warehouse_inventory = WarehouseInventory::create($input);
          foreach ($request->products as $product_id=>$quanities) { 
              // dd($quanities);
                $data = [
                  'inventory_id' => $warehouse_inventory->id,
                  'product_id' => $product_id,
                  'old_quantity' => $quanities['old'],
                  'new_quantity' => $quanities['new_quantity'],
                  'variation_id' => $quanities['variation_id'],
                  'is_inability' => $quanities['new_quantity'] < $quanities['old'] ? 1 : 0,
                ];
               $details = WarehouseInventoryProduct::create($data);
               $quanities = $details->old_quantity - $details->new_quantity;

               $input_data= [
                 'location_id'=> $warehouse_inventory->location_id,
                 'transaction_date' =>$input['date'],
                 'adjustment_type' =>'abnormal',
                 'total_amount_recovered' =>'0',
                 'ref_no' =>null,
                 'final_total' =>$details->product->variations()->latest()->first()->default_purchase_price * ($quanities),
               ];
               $products = [
                 ['product_id' => $details->product_id,
                 'variation_id' => $details->variation_id,
                 'quantity' => $quanities,
                 'price' => $details->product->variations()->latest()->first()->default_purchase_price * $quanities,
                 'unit_price' => $details->product->variations()->latest()->first()->default_purchase_price * $quanities,]
               ];
              //  dd($quanities);
               if($quanities > 0){
                $this->decreaseQuantity($input_data , $products, false);
               }elseif($quanities < 0){
                $this->decreaseQuantity($input_data , $products, true);
               }
          }
          DB::commit();

          
            $output = ['success' => true,
                            'data' => $warehouse_inventory,
                            'msg' => __("lang_v1.success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            // dd($e);
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

        return redirect('/warehouse-inventory')->with(['status'=>$output]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerGroup  $customerGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
      $business_id = request()->session()->get('user.business_id');
      $warehouse_inventory = WarehouseInventory::with('inventory_products')->where('business_id', $business_id)->find($id);
      return view('warehouse_inventory.edit')->with(compact('warehouse_inventory'));
    }


    public function show($id){
      $business_id = request()->session()->get('user.business_id');
      $warehouse_inventory = WarehouseInventory::with('inventory_products')->where('business_id', $business_id)->find($id);
      return view('warehouse_inventory.show')->with(compact('warehouse_inventory'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            try {
              $input = $request->except('products');
              $business_id = request()->session()->get('user.business_id');

              $input['date'] = !empty($input['date']) ?Carbon::parse($input['date'])->format('Y-m-d H:i:s') : date('Y-m-d H:i:s');
              $warehouse_inventory = WarehouseInventory::where('business_id', $business_id)->findOrFail($id);
              // dd($input);
              $warehouse_inventory->update($input);
              WarehouseInventoryProduct::where('inventory_id',$warehouse_inventory->id)->delete();
              foreach ($request->products as $product_id=>$quanities) { 
                $data = [
                  'inventory_id' => $warehouse_inventory->id,
                  'product_id' => $product_id,
                  'old_quantity' => $quanities['old'],
                  'new_quantity' => $quanities['new_quantity'],
                  'variation_id' => $quanities['variation_id'],
                  'is_inability' => $quanities['new_quantity'] < $quanities['old'] ? 1 : 0,
                ];
                  $details = WarehouseInventoryProduct::create($data);
                  $quanities = $details->old_quantity - $details->new_quantity;
   
                  $input_data= [
                    'location_id'=> $warehouse_inventory->location_id,
                    'transaction_date' =>$input['date'],
                    'adjustment_type' =>'abnormal',
                    'total_amount_recovered' =>'0',
                    'ref_no' =>null,
                    'final_total' =>$details->product->variations()->latest()->first()->default_purchase_price * ($quanities),
                  ];
                  $products = [
                    ['product_id' => $details->product_id,
                    'variation_id' => $details->variation_id,
                    'quantity' => $quanities,
                    'price' => $details->product->variations()->latest()->first()->default_purchase_price * $quanities,
                    'unit_price' => $details->product->variations()->latest()->first()->default_purchase_price * $quanities,]
                  ];
                 //  dd($quanities);
                  if($quanities > 0){
                   $this->decreaseQuantity($input_data , $products, false);
                  }elseif($quanities < 0){
                   $this->decreaseQuantity($input_data , $products, true);
                  
                }
               
               }
              $output = ['success' => true,
                          'msg' => __("lang_v1.success")
                          ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return  redirect('/warehouse-inventory')->with(['status'=>$output]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;

                WarehouseInventoryProduct::where('inventory_id',$id)->delete();
                WarehouseInventory::where('business_id', $business_id)->findOrFail($id)->delete();
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



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decreaseQuantity($input_data ,$products , $increase= false)
    {

            $business_id = request()->session()->get('user.business_id');

            // //Check if subscribed or not
            // if (!$this->moduleUtil->isSubscribed($business_id)) {
            //     return $this->moduleUtil->expiredResponse(action('StockAdjustmentController@index'));
            // }
        
            $user_id = request()->session()->get('user.id');

            $input_data['type'] = 'stock_adjustment';
            $input_data['business_id'] = $business_id;
            $input_data['created_by'] = $user_id;
            // $input_data['transaction_date'] = $this->productUtil->uf_date($input_data['transaction_date'], true);
            $input_data['total_amount_recovered'] = $this->productUtil->num_uf($input_data['total_amount_recovered']);

            //Update reference count
            $ref_count = $this->productUtil->setAndGetReferenceCount('stock_adjustment');
            //Generate reference number
            if (empty($input_data['ref_no'])) {
                $input_data['ref_no'] = $this->productUtil->generateReferenceNumber('stock_adjustment', $ref_count);
            }

            // $products = $request->input('products');

            if (!empty($products)) {
                $product_data = [];
                foreach ($products as $product) {
                    $adjustment_line = [
                        'product_id' => $product['product_id'],
                        'variation_id' => $product['variation_id'],
                        'quantity' => $this->productUtil->num_uf($product['quantity']),
                        'unit_price' => $this->productUtil->num_uf($product['unit_price'])
                    ];
                    
                    $product_data[] = $adjustment_line;
                   

                   if ($increase == false) {
                     //Decrease available quantity
                     $this->productUtil->decreaseProductQuantity(
                      $product['product_id'],
                      $product['variation_id'],
                      $input_data['location_id'],
                      $this->productUtil->num_uf($product['quantity'])
                  );
                   }else{
                     //increase available quantity
                     $this->productUtil->increaseProductQuantity(
                      $product['product_id'],
                      $product['variation_id'],
                      $input_data['location_id'],
                      $this->productUtil->num_uf($product['quantity'])
                  );
                   }
                }
                $stock_adjustment = Transaction::create($input_data);
                $stock_adjustment->stock_adjustment_lines()->createMany($product_data);

                //Map Stock adjustment & Purchase.
                $business = ['id' => $business_id,
                                'accounting_method' => request()->session()->get('business.accounting_method'),
                                'location_id' => $input_data['location_id']
                            ];
                $this->transactionUtil->mapPurchaseSell($business, $stock_adjustment->stock_adjustment_lines, 'stock_adjustment');

                $this->transactionUtil->activityLog($stock_adjustment, 'added', null, [], false);
            }

            // $output = ['success' => 1,
            //                 'msg' => __('stock_adjustment.stock_adjustment_added_successfully')
            //             ];

       

    }
}
