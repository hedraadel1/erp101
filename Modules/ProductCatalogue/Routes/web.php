<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Before Login Dashboard Routes
Route::group(['prefix' => 'product-catalogue'], function ()  {
    $controller = 'AuthController@';
    // Route Login
    Route::get('login', $controller . 'viewLogin')->name('product_catalogue.login');
    Route::post('store-login', $controller . 'login')->name('product_catalogue.makelogin');
    Route::post('store', $controller . 'store')->name('product_catalogue.store');
    Route::get('register', $controller . 'getRegister')->name('product_catalogue.register');

});
Route::group([ 'middleware' => ['web', 'authh', 'CheckLogin', 'SetSessionData',  'language', 'timezone'],'namespace' => '\Modules\ProductCatalogue\Http\Controllers'], function () {
	Route::get('/catalogue/{business_id}/{location_id}', 'ProductCatalogueController@index')->name('catalogue.view');
	Route::get('/show-catalogue/{business_id}/{product_id}', 'ProductCatalogueController@show');

	Route::get('/product-catalogue/cart', 'CartController@index')->name('product_catalogue.cart');
  Route::post('/product-catalogue/addToCart', 'CartController@storeCart')->name('product_catalogue.storeCart');
  Route::post('/product-catalogue/delete-item', 'CartController@deleteItem')->name('product_catalogue.deleteItem');
  Route::post('/product-catalogue/storeOrder', 'CartController@storeOrder')->name('product_catalogue.storeOrder');
  Route::post('/product-catalogue/updateCart', 'CartController@update')->name('product_catalogue.updatecart');

});

Route::group(['middleware' => ['web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu'], 'namespace' => '\Modules\ProductCatalogue\Http\Controllers', 'prefix' => 'product-catalogue'], function () {
    Route::get('catalogue-qr', 'ProductCatalogueController@generateQr');

    Route::get('install', 'InstallController@index');
    Route::post('install', 'InstallController@install');
    Route::get('install/uninstall', 'InstallController@uninstall');
    Route::get('install/update', 'InstallController@update');
});
