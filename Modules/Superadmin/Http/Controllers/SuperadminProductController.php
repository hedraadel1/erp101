<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Http\Middleware\Superadmin;
use App\User;
use App\Utils\TransactionUtil;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

use DB;
use Modules\Superadmin\Entities\SuperadminBusinessProduct;
use Modules\Superadmin\Entities\SuperadminProduct;
use Modules\Superadmin\Entities\SuperadminProductDiscount;
use Modules\Superadmin\Entities\SuperadminProductMedia;

class SuperadminProductController extends BaseController
{

  protected $transactionUtil;


  public function __construct(TransactionUtil $transactionUtil)
  {
    $this->transactionUtil = $transactionUtil;
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

      $products = SuperadminProduct::latest()->get();

      return Datatables::of($products)
        ->addColumn(
          'action',
          function ($row) {
            return '<span style="display:flex"> <a href="' . action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@productDetails', $row->id) . '" class="btn btn-sm Btn-Brand btn-info " ><i class="fa fa-eye"></i>' . __("messages.view") . '</a>
                            &nbsp;
                      <a href="' . action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@edit', $row->id) . '" class="btn btn-sm Btn-Brand Btn-Primary " ><i class="glyphicon glyphicon-edit"></i>' . __("messages.edit") . '</a>
                          &nbsp;
                          <button data-href="' . action('\Modules\Superadmin\Http\Controllers\SuperadminProductController@destroy', $row->id) . '" class="btn btn-sm Btn-Brand btn-danger delete_superadmin_products_button"><i class="glyphicon glyphicon-trash"></i> ' . __("messages.delete") . '</button> </span>';
          }
        )
        ->editColumn('image', function ($row) {
          $html = '<div style="display: flex;"><img src="' . $row->image_url . '" alt="Product image" class="product-thumbnail-small"></div>';
          return $html;
        })
        ->editColumn('price', function ($row) {

          return $this->transactionUtil->num_f($row->price_after_discount, true);
        })
        ->editColumn('free_price', function ($row) {

          return $this->transactionUtil->num_f($row->free_price, true);
        })
        ->removeColumn('id')
        ->rawColumns(['action', 'image'])
        ->make(true);
    }

    return view('superadmin::superadmin_products.index');
  }


  public function create()
  {
    $product = new SuperadminProduct();
    return view('superadmin::superadmin_products.form', compact('product'));
  }



  public function edit($id)
  {
    $product  = SuperadminProduct::with('product_discount')->findOrFail($id);
    return view('superadmin::superadmin_products.form', compact('product'));
  }


  public function show($id)
  {
  }
  /**
   * 
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    //Disable in demo
    if (config('app.env') == 'demo') {
      $output = [
        'success' => 0,
        'msg' => 'Feature disabled in demo!!'
      ];
      return back()->with('status', $output);
    }


    $product_details = $request->only('name', 'description', 'duration', 'is_expire', 'price', 'is_distinct', 'is_unique', 'is_required');
    $product_discount = $request->only('type', 'discount', 'date_from', 'date_to', 'is_limited_offer');
    if ($request->image) {
      $product_details['image'] = uploadFile($request->image, 'uploads/superadmin/products/');
    }
    $product_details['code'] = $this->genarateCode();
    $product = SuperadminProduct::create($product_details);
    if ($request->discount != null) {
      $product_discount['product_id'] = $product->id;
      SuperadminProductDiscount::create($product_discount);
    }
    if ($request->media) {
      foreach ($request->media as $key => $item) {
        $media = [
          'product_id' => $product->id,
          'media' => uploadFile($item, 'uploads/superadmin/products/' . $product->id . '/')
        ];
        SuperadminProductMedia::create($media);
      }
    }
    if ($request->is_required) {

      //Get business owners
      $business_owners = User::join('business as B', 'users.id', '=', 'B.owner_id')
        ->select('users.*')
        ->groupBy('users.id')
        ->get();

      //Send notifications
      // \Notification::send($business_owners, new SuperadminP  roductNotifiction($product));
    }
    $output = [
      'success' => 1,
      'msg' => __('lang_v1.success')
    ];

    return redirect('superadmin/products')->with('status', $output);
  }

  /**
   * 
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request, $id)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    //Disable in demo
    if (config('app.env') == 'demo') {
      $output = [
        'success' => 0,
        'msg' => 'Feature disabled in demo!!'
      ];
      return back()->with('status', $output);
    }

    $product_details = $request->only('name', 'description', 'duration', 'is_expire', 'price', 'is_distinct', 'is_unique', 'is_required');
    $product_discount = $request->only('type', 'discount', 'date_from', 'date_to', 'is_limited_offer');
    if ($request->image) {
      $product_details['image'] = uploadFile($request->image, 'uploads/superadmin/products/');
    }

    $product = SuperadminProduct::where('id', $id)->first();
    $product->update($product_details);
    if ($request->discount != null) {
      $product_discount['product_id'] = $product->id;
      $pro_discount = SuperadminProductDiscount::where('product_id', $id)->first();
      if ($pro_discount) {
        $pro_discount->update($product_discount);
      } else {
        SuperadminProductDiscount::create($product_discount);
      }
    }
    if ($request->media) {
      foreach ($request->media as $key => $item) {
        $media = [
          'product_id' => $product->id,
          'media' => uploadFile($item, 'uploads/superadmin/products/' . $product->id . '/')
        ];
        SuperadminProductMedia::create($media);
      }
    }
    $output = [
      'success' => 1,
      'msg' => __('lang_v1.updated')
    ];

    return redirect('superadmin/products')->with('status', $output);
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

        $media = SuperadminProductMedia::where('product_id', $id)->get();
        foreach ($media as $item) {
          $path = $item->media ? public_path($item->media) : null;
          if (file_exists($path)) {
            unlink($path);
          }
          $item->delete();
        }
        SuperadminProductDiscount::where('product_id', $id)->delete();
        SuperadminProduct::where('id', $id)->delete();
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

  /**
   * delete a item of media
   * @param id of media
   */
  public function deleteMedia($id)
  {
    $data = SuperadminProductMedia::findOrFail($id);
    if ($data) {
      $path = $data->media ? public_path($data->media) : null;
      if (file_exists($path)) {
        unlink($path);
      }
      $data->delete();
      $output = ['success' => 1, 'msg' => 'تم حذف العنصر'];
    } else {
      $output = ['success' => 0, 'msg' => __("messages.something_went_wrong")];
    }
    return back()->with('status', $output);
  }

  /**
   * check code is exists or no
   */
  private function checkCodeExists($code)
  {
    $product = SuperadminProduct::where('code', $code)->first();
    return $product ? true : false;
  }
  /**
   * check code is exists or no
   */
  private function genarateCode()
  {
    $code = 200;
    $product = SuperadminProduct::latest()->first();
    if ($product) {
      return $product->code + 1;
    } else {
      return  $code + 1;
    }
  }


  public function shortCreate()
  {
    $business_id = request()->input('business_id');
    $product_ids = SuperadminBusinessProduct::where('business_id', $business_id)->pluck('product_id')->toArray();
    $products = SuperadminProduct::whereNotIn('id', $product_ids)->latest()->pluck('name', 'id')->toArray();
    return view('superadmin::superadmin_products.add_product')
      ->with(compact('business_id', 'products'));
  }

  /**
   * store product in business from busiess page
   */
  public function storeProduct(Request $request)
  {
    $inputs = $request->all();
    $product = SuperadminProduct::where('id', $inputs['product_id'])->first();
    if (isset($inputs['paid'])) {
      $wallet = Wallet::where('business_id', $inputs['business_id'])->first();
      $data = [
        'amount' => $product->price_after_discount,
        'business_id' => $inputs['business_id'],
        'product_id'  => $product->id,
        'product_code' => $product->code,
      ];
      if ($request->start_date) {
        $data['start_date'] = $request->start_date;
        $data['end_date'] = $request->end_date;
        $data['is_expire'] = 1;
      }
      if ($wallet->free_money >= $product->free_price && ($product->free_price != null || $product->free_price != 0)) {
        SuperadminBusinessProduct::where('product_id', $inputs['product_id'])->delete();
        $this->payProductAndUpdatePackage($product, $data);
        $wallet->update([
          'free_money' => $wallet->free_money  -  $product->free_price
        ]);
      } elseif ($wallet->amount >= $product->price_after_discount) {
        SuperadminBusinessProduct::where('product_id', $inputs['product_id'])->delete();

        $this->payProductAndUpdatePackage($product, $data);
        $wallet->update([
          'amount' => $wallet->amount  -  $product->price_after_discount
        ]);
      }
    } elseif (isset($inputs['type'])) {
      SuperadminBusinessProduct::where('product_id', $inputs['product_id'])->where('paid_type', '!=', 'day')->delete();
      $data = [
        'amount' => $inputs['amount'],
        'business_id' => session('business.id'),
        'product_id'  => $inputs['product_id'],
        'product_code' => $inputs['product_code'],
        'start_date' => Carbon::now()->format('Y-m-d'),
        'end_date' => Carbon::tomorrow()->format('Y-m-d'),
        'paid_type' => 'day',
      ];
      $data['is_expire'] = 1;
      SuperadminBusinessProduct::where('product_id', $inputs['product_id'])->where('paid_type', '!=', 'day')->delete();
      $this->payProductAndUpdatePackage($product, $data);
    }
    $output = ['success' => 1, 'msg' => 'تم شراء المنتج'];

    return  $output;
  }
  /**
   * store product in business from busiess page
   */
  public function payProduct(Request $request)
  {
    $wallet = Wallet::where('business_id', session('business.id'))->first();
    $inputs = $request->all();
    $product = SuperadminProduct::where('id', $inputs['product_id'])->first();
    if ($wallet) {
      // dd($wallet->amount >= $product->price_after_discount);
      if ($wallet->amount >= $product->price_after_discount) {
        $data = [
          'amount' => $inputs['amount'],
          'business_id' => session('business.id'),
          'product_id'  => $inputs['product_id'],
          'product_code' => $inputs['product_code'],
          'paid_type'  => $inputs['type'],
        ];
        if ($wallet->free_money >= $product->free_price && ($product->free_price != null || $product->free_price != 0)) {
          SuperadminBusinessProduct::where('product_id', $inputs['product_id'])->where('paid_type', '!=', 'day')->delete();
          $this->payProductAndUpdatePackage($product, $data);
          $wallet->update([
            'free_money' => $wallet->free_money  -  $product->free_price
          ]);
        } elseif ($wallet->amount >= $product->price_after_discount) {
          SuperadminBusinessProduct::where('product_id', $inputs['product_id'])->where('paid_type', '!=', 'day')->delete();

          $this->payProductAndUpdatePackage($product, $data);
          $wallet->update([
            'amount' => $wallet->amount  -  $product->price_after_discount
          ]);
        }
        $output = ['success' => 1, 'msg' => 'تم شراء المنتج'];
      } else {

        $output = ['error' => 1, 'msg' => 'رصيد المحفظة غير كافي لعملية الشراء'];
      }
    } else {
      $output = ['error' => 1, 'msg' => 'رصيد المحفظة غير كافي لعملية الشراء'];
    }

    return $output;
  }

  public function showBusinessProduct($id)
  {
    $business_id = $id;
    $product_ids = SuperadminBusinessProduct::where('business_id', $business_id)->pluck('product_id')->toArray();
    $products = SuperadminProduct::whereIn('id', $product_ids)->latest()->get();
    // dd($products);
    return view('superadmin::superadmin_products.business_products')
      ->with(compact('business_id', 'products'));
  }

  /**
   * delete a item of media
   * @param id of media
   */
  public function deleteProduct($id)
  {
    $data = SuperadminBusinessProduct::where('product_id', $id)->first();
    if ($data) {

      $package = \Modules\Superadmin\Entities\Subscription::active_subscription($data->business_id);
      // dd($data);   
      $details = $package->package_details;
      foreach ($package->package_details as $key => $value) {
        if ($key == $data->product_code) {
          $details[$key] = 0;
        }
      }
      $package->package_details = $details;
      $package->save();
      $data->delete();
      $output = ['success' => 1, 'msg' => 'تم حذف العنصر'];
    } else {
      $output = ['success' => 0, 'msg' => __("messages.something_went_wrong")];
    }
    return back()->with('status', $output);
  }




  /**
   * return product tostores list for business
   */
  public function getBrandStore()
  {
    $products = SuperadminProduct::latest()->paginate('20');
    $business_products_ids = SuperadminBusinessProduct::where('business_id', session('business.id'))->pluck('product_id')->toArray();

    return view('superadmin::superadmin_products.brand_store')->with(compact('products', 'business_products_ids'));
  }
  /**
   * return product tostores list for business
   */
  public function getBrandStoreIfram()
  {
    $products = SuperadminProduct::latest()->get();
    return view('superadmin::superadmin_products.ifram')->with(compact('products'));
  }



  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function productDetails($id)
  {
    // Get the product from the database.
    $product = SuperadminProduct::find($id);

    // Get the business product for the product.
    $business_product = SuperadminBusinessProduct::where('business_id', session('business.id'))->where('product_id', $id)->where('paid_type', 'day')->first();

    // Get the product codes.
    $product_cods = $product->code;

    // If the product does not exist, redirect to the 404 page.
    if (!$product) {
      return abort(404);
    }
    $product_cods = ['123456', '789012'];

    // Return the view with the product details.
    return view('superadmin::superadmin_products.product_details', [
      'product' => $product,
      'business_product' => $business_product,
      'product_cods' => $product_cods,
    ]);
  }

  /**
   * check  product duration
   */
  public function checkDuration(Request $request)
  {
    $product = SuperadminProduct::findOrFail($request->id);
    $is_duration = $product->is_expire == 1 ? true : false;
    return response()->json($is_duration);
  }

  private function payProductAndUpdatePackage($product, $data)
  {
    $product_cods = ['212'];
    $package = \Modules\Superadmin\Entities\Subscription::active_subscription($data['business_id']);
    $details = $package->package_details;
    foreach ($package->package_details as $key => $value) {
      if ($key == $product->code) {
        $details[$key] = 1;
      }
      if ($product->code = '212') {
        $details['location_count'] = $details['location_count'] + 1;
        // dd($details['location_count']);
      }
    }
    $package->package_details = $details;
    $package->save();
    SuperadminBusinessProduct::create($data);
  }

  /**
   * hide  product unique
   */
  public function hideProduct(Request $request)
  {

    foreach ($request->products_ids as $key => $value) {
      DB::table('hide_product_users')->insert(['user_id' => auth()->user()->id, 'product_id' => $value]);
    }
    return back();
  }
}