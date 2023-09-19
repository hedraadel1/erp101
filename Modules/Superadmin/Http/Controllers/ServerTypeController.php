<?php

namespace Modules\Superadmin\Http\Controllers;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\System;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use Illuminate\Http\Response;
use Modules\Superadmin\Entities\ServerType;

class ServerTypeController extends Controller
{
  /**
   * All Utils instance.
   *
   */
  protected $businessUtil;


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

    $serverTypes = ServerType::orderby('server_name', 'asc')
      ->paginate(20);

    // $serverTypes = ServerType::scopeListServerTypes()->get();
    return view('superadmin::server_type.index')
      ->with(compact('serverTypes'));
  }

  public function create()
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    $currency = System::getCurrency();
    return view('superadmin::server_type.create')->with(compact('currency'));;
  }

  public function store(Request $request)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    try {
      $input = $request->only(['server_name', 'image_path', 'icon_path', 'server_speed', 'server_cpu', 'server_ram', 'server_network', 'server_pr_limit', 'server_response_time_range', 'server_price_perday', 'status', 'available']);
      $currency = System::getCurrency();
      $input['created_by'] = $request->session()->get('user.id');

      if (empty($input['image_path'])) {
        $input['image_path'] = 'https://www.onoo.pro/erp10/public/images/icons/dockbar/letter-b.png';
      }

      if (empty($input['icon_path'])) {
        $input['icon_path'] = 'https://www.onoo.pro/erp10/public/images/icons/dockbar/letter-b.png';
      }

      if (empty($input['server_speed'])) {
        $input['server_speed'] = 1;
      }

      if (empty($input['server_cpu'])) {
        $input['server_cpu'] = 1;
      }

      if (empty($input['server_ram'])) {
        $input['server_ram'] = 1;
      }

      if (empty($input['server_network'])) {
        $input['server_network'] = 1;
      }

      if (empty($input['server_pr_limit'])) {
        $input['server_pr_limit'] = 1;
      }

      if (empty($input['server_response_time_range'])) {
        $input['server_response_time_range'] = 1;
      }


      $input['server_price_perday'] = $this->businessUtil->num_uf($input['server_price_perday'], $currency);

      $serverType = new ServerType();
      $serverType->fill($input);
      $serverType->save();

      $output = ['success' => 1, 'msg' => __('lang_v1.success')];
    } catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

      $output = [
        'success' => 0,
        'msg' => __('messages.something_went_wrong')
      ];
    }

    return redirect()
      ->action('\Modules\Superadmin\Http\Controllers\ServerTypeController@index')
      ->with('status', $output);
  }


  public function edit($id)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    $serverType = ServerType::findOrFail($id);

    return view('superadmin::server_type.edit', compact('serverType'));
  }


  public function update(Request $request, $id)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    try {
      $input = $request->only(['server_name', 'image_path', 'icon_path', 'server_speed', 'server_cpu', 'server_ram', 'server_network', 'server_pr_limit', 'server_response_time_range', 'server_price_perday', 'status', 'available']);

      $serverType = ServerType::findOrFail($id);
      $serverType->fill($input);
      $serverType->save();

      $output = ['success' => 1, 'msg' => __('lang_v1.success')];
    } catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

      $output = [
        'success' => 0,
        'msg' => __('messages.something_went_wrong')
      ];
    }
    return redirect()                
    ->action('\Modules\Superadmin\Http\Controllers\ServerTypeController@index')
    ->with('status', $output);
  }

  public function destroy($id)
  {
    if (!auth()->user()->can('superadmin')) {
      abort(403, 'Unauthorized action.');
    }

    try {
      $serverType = ServerType::findOrFail($id);
      $serverType->delete();

      $output = ['success' => 1, 'msg' => __('lang_v1.success')];
    } catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

      $output = [
        'success' => 0,
        'msg' => __('messages.something_went_wrong')
      ];
    }
    return redirect()
      ->action('Superadmin\ServerTypeController@index')
      ->with('status', $output);
  }
}