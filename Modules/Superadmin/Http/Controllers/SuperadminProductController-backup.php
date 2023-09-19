<?php

namespace Modules\Superadmin\Http\Controllers;

use Modules\Superadmin\Entities\SuperadminProduct;
use Modules\Superadmin\Entities\SuperadminBusinessProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class SuperadminProductController extends BaseController
{
    /**
   * Hide the product for the user.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function hideProduct(Request $request)
  {
    // Get the product ID.
    $product_id = $request->input('product_id');

    // Check if the user is authorized to hide products.
    if (!auth()->user()->can('hideProducts')) {
      return response()->json(['error' => 'You are not authorized to hide products.'], 401);
    }

    // Check if the product ID is valid.
    if (!$product_id) {
      return response()->json(['error' => 'Product ID is not valid.'], 422);
    }

    // Check if the product is already hidden for the user.
    if (in_array($product_id, $hidden_product_ids)) {
      return response()->json(['error' => 'Product is already hidden.'], 422);
    }

    // Hide the product for the user.
    DB::table('hide_product_users')->insert([
      'user_id' => auth()->user()->id,
      'product_id' => $product_id,
    ]);

    // Return a success message.
    return response()->json(['success' => 'Product hidden successfully.'], 200);
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
    $business_product = $product->business_product;

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
}