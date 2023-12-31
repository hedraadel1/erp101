<?php

Route::group(['prefix' => 'ai', 'namespace' => 'app/Utils/TransactionUtil'], function () {
  Route::post('/auto', 'TransactionUtil@sendNotificationWhatsapp');
});

Route::group(['prefix' => 'connector', 'namespace' => 'Modules\Connector\Http\Controllers\Api'], function () {
  Route::post('/login', 'AuthController@login');
  Route::post('auto', 'AutoResponderController@store');
});

Route::group(['middleware' => ['web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'], 'prefix' => 'connector', 'namespace' => 'Modules\Connector\Http\Controllers'], function () {
  Route::get('/api', 'ConnectorController@index');
  Route::resource('/client', 'ClientController');
  Route::get('/regenerate', 'ClientController@regenerate');
});


Route::group(['middleware' => ['auth:api'], 'prefix' => 'D', 'namespace' => 'Modules\Connector\Http\Controllers\Api'], function () {
  Route::resource('business-location', 'BusinessLocationController', ['only' => ['index', 'show']]);

  Route::resource('contactapi', 'ContactController', ['only' => ['index', 'show', 'store', 'update']]);

  Route::post('contactapi-payment', 'ContactController@contactPay');

  Route::resource('unit', 'UnitController', ['only' => ['index', 'show']]);

  Route::resource('taxonomy', 'CategoryController', ['only' => ['index', 'show']]);

  Route::resource('brand', 'BrandController', ['only' => ['index', 'show']]);
  Route::resource('category2', 'category2Controller ', ['only' => ['index', 'show']]);

  Route::resource('product', 'ProductController', ['only' => ['index', 'show']]);

  Route::get('selling-price-group', 'ProductController@getSellingPriceGroup');

  Route::get('variation/{id?}', 'ProductController@listVariations');
  Route::get('getpro', 'ProductController@getpro');

  Route::resource('tax', 'TaxController', ['only' => ['index', 'show']]);

  Route::resource('table', 'TableController', ['only' => ['index', 'show']]);

  Route::get('user/loggedin', 'UserController@loggedin');
  Route::post('user-registration', 'UserController@registerUser');
  Route::resource('user', 'UserController', ['only' => ['index', 'show']]);
  Route::get('get-user-id', 'UserController@getUserId');


  Route::resource('types-of-service', 'TypesOfServiceController', ['only' => ['index', 'show']]);

  Route::get('payment-accounts', 'CommonResourceController@getPaymentAccounts');

  Route::get('payment-methods', 'CommonResourceController@getPaymentMethods');

  Route::resource('sell', 'SellController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

  Route::get('agents', 'AgentController@index');
  Route::post('agents/store', 'AgentController@store');

  Route::post('sell-return', 'SellController@addSellReturn');

  Route::get('list-sell-return', 'SellController@listSellReturn');

  Route::post('update-shipping-status', 'SellController@updateSellShippingStatus');

  Route::resource('expense', 'ExpenseController', ['only' => ['index', 'store', 'show', 'update']]);
  Route::get('expense-refund', 'ExpenseController@listExpenseRefund');

  Route::get('expense-categories', 'ExpenseController@listExpenseCategories');

  Route::resource('cash-register', 'CashRegisterController', ['only' => ['index', 'store', 'show', 'update']]);

  Route::get('business-details', 'CommonResourceController@getBusinessDetails');
  Route::get('get-business-id', 'CommonResourceController@getBusinessId');

  Route::get('profit-loss-report', 'CommonResourceController@getProfitLoss');

  Route::get('product-stock-report', 'CommonResourceController@getProductStock');
  Route::get('notifications', 'CommonResourceController@getNotifications');

  Route::get('active-subscription', 'SuperadminController@getActiveSubscription');
  Route::get('packages', 'SuperadminController@getPackages');

  Route::get('get-attendance/{user_id}', 'AttendanceController@getAttendance');
  Route::post('clock-in', 'AttendanceController@clockin');
  Route::post('clock-out', 'AttendanceController@clockout');
  Route::get('holidays', 'AttendanceController@getHolidays');
  Route::post('update-password', 'UserController@updatePassword');
  Route::post('forget-password', 'UserController@forgetPassword');
  Route::get('get-location', 'CommonResourceController@getLocation');
  Route::post('check-user-location', 'AttendanceController@checkUserLocation');

  Route::get('new_product', 'ProductSellController@newProduct')->name('new_product');
  Route::get('new_sell', 'ProductSellController@newSell')->name('new_sell');
  Route::get('new_contactapi', 'ProductSellController@newContactApi')->name('new_contactapi');
});
Route::group(['middleware' => ['auth:api', 'timezone'], 'prefix' => 'connector/api/essentail', 'namespace' => 'Modules\Connector\Http\Controllers\Api\Essentail'], function () {
  //todo controller
  Route::get('todo', 'ToDoController@index');
  Route::post('todo', 'ToDoController@store');
  Route::get('todo/{id}', 'ToDoController@show');
  Route::put('todo/{id}', 'ToDoController@update');
  Route::post('todo/update-status/{id}', 'ToDoController@update_Status');
  Route::delete('todo/{id}', 'ToDoController@destroy');
  Route::post('todo/add-comment', 'ToDoController@addComment');
  Route::get('todo/delete-comment/{id}', 'ToDoController@deleteComment');
  Route::post('todo/upload-document', 'ToDoController@uploadDocument');
  Route::get('todo/delete-document/{id}', 'ToDoController@deleteDocument');


  // Route::resource('todo', 'ToDoController');

  // 
  // ;
  // Route::get('todo/delete-document/{id}', 'ToDoController@deleteDocument');
  // 
  // Route::get('view-todo-{id}-share-docs', 'ToDoController@viewSharedDocs');
});

Route::group(['middleware' => ['auth:api', 'timezone'], 'prefix' => 'connector/api/crm', 'namespace' => 'Modules\Connector\Http\Controllers\Api\Crm'], function () {

  Route::resource('follow-ups', 'FollowUpController', ['only' => ['index', 'store', 'show', 'update']]);

  Route::get('follow-up-resources', 'FollowUpController@getFollowUpResources');

  Route::get('leads', 'FollowUpController@getLeads');

  Route::post('call-logs', 'CallLogsController@saveCallLogs');
});

Route::group(['middleware' => ['auth:api', 'timezone'], 'prefix' => 'connector/api', 'namespace' => 'Modules\Connector\Http\Controllers\Api\FieldForce'], function () {
  Route::get('field-force', 'FieldForceController@index');
  Route::post('field-force/create', 'FieldForceController@store');
  Route::post('field-force/update-visit-status/{id}', 'FieldForceController@updateStatus');
});

Route::group(['middleware' => ['web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu', 'CheckUserLogin'], 'namespace' => 'Modules\Connector\Http\Controllers', 'prefix' => 'connector'], function () {
  Route::get('install', 'InstallController@index');
  Route::post('install', 'InstallController@install');
  Route::get('install/uninstall', 'InstallController@uninstall');
  Route::get('install/update', 'InstallController@update');
});