<?php

namespace Modules\Superadmin\Http\Controllers;

use App\SettingGoFast;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Yajra\DataTables\Facades\DataTables;

class SettingGoFastController extends BaseController
{
  public function index()
  {
    if (request()->ajax()) {
    $menus = SettingGoFast::latest()->get();
      return DataTables::of($menus)
              ->addColumn(
                'action',
                function($row){
                  return '
                      <a role="button" data-href="'.action('\Modules\Superadmin\Http\Controllers\SettingGoFastController@edit', $row->id).'" class="btn btn-xs btn-primary btn-modal" data-container=".menu_modal"><i class="glyphicon glyphicon-edit"></i>'. __("messages.edit").'</a>
                      &nbsp;
                      <button data-href="'.action('\Modules\Superadmin\Http\Controllers\SettingGoFastController@destroy', $row->id).'" class="btn btn-xs btn-danger delete_menu_button"><i class="glyphicon glyphicon-trash"></i> '.__("messages.delete").'</button>';
                }
              )
              ->editColumn('id', function ($row) {
                return $row->id.' #' ;
                })
              ->rawColumns(['action'])
              ->make(true);
    }
    return view('superadmin::setting_gofast.index');
  }


   public function create()
  {
    $menu = new SettingGoFast();
    return view('superadmin::setting_gofast.form',compact('menu'));
  }
  

  public function show()
  {

  }
  public function store(Request $request)
  {
    $inputs = $request->all();
    try {
     
      SettingGoFast::create($inputs);
      $output = ['success' => true,
                  'msg' => __("lang_v1.success")
              ];
    }catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
      $output = ['success' => false,
                  'msg' => __("messages.something_went_wrong")
              ];
    }
    return $output;
  }

  public function edit($id)
  {
    $menu =  SettingGoFast::findOrFail($id);
    return view('superadmin::setting_gofast.form',compact('menu'));
  }

  public function update(Request $request, $id)
  {
    $inputs = $request->all();
    try {
      $menu =  SettingGoFast::findOrFail($id);
     $menu->update($inputs);
      $output = ['success' => true,
                  'msg' => __("lang_v1.success")
              ];
    }catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
      $output = ['success' => false,
                  'msg' => __("messages.something_went_wrong")
              ];
    }
    return $output;
  }


  public function destroy($id)
  {
    if (request()->ajax()) {
      try {

          $menu = SettingGoFast::findOrFail($id)->delete();
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

}
