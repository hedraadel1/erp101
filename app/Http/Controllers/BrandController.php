<?php

namespace App\Http\Controllers;

use App\Brands;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
  /**
   * All Utils instance.
   *
   */
  protected $moduleUtil;

  /**
   * Constructor
   *
   * @param ProductUtils $product
   * @return void
   */
  public function __construct(ModuleUtil $moduleUtil)
  {
    $this->moduleUtil = $moduleUtil;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (!auth()->user()->can('brand.view') && !auth()->user()->can('brand.create')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      $business_id = request()->session()->get('user.business_id');

      $view_cache_key = 'brand.index.' . $business_id;
      $view_data = cache()->tags(['brand'])->get($view_cache_key);
      if (is_null($view_data)) {
        $view_data = Datatables::of(Brands::where('business_id', $business_id)
          ->select(['name', 'description', 'id']))
          ->addColumn(
            'action',
            '@can("brand.update")
                        <button data-href="{{action(\'BrandController@edit\', [$id])}}" class="btn Btn-Brand Btn-bx Btn-Primary edit_brand_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                            &nbsp;
                        @endcan
                        @can("brand.delete")
                            <button data-href="{{action(\'BrandController@destroy\', [$id])}}" class="btn Btn-Brand Btn-bx  btn-danger delete_brand_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                        @endcan'
          )
          ->removeColumn('id')
          ->rawColumns([2])
          ->make(false);

        cache()->tags(['brand'])->put($view_cache_key, $view_data, 60);
      }

      echo "The brands are " . (is_null($view_data) ? "not cached" : "cached");
      
    }
    return view('brand.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (!auth()->user()->can('brand.create')) {
      abort(403, 'Unauthorized action.');
    }

    $quick_add = false;
    if (!empty(request()->input('quick_add'))) {
      $quick_add = true;
    }

    $is_repair_installed = $this->moduleUtil->isModuleInstalled('Repair');

    return view('brand.create')
      ->with(compact('quick_add', 'is_repair_installed'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!auth()->user()->can('brand.create')) {
      abort(403, 'Unauthorized action.');
    }

    try {
      $input = $request->only(['name', 'description']);
      $business_id = $request->session()->get('user.business_id');
      $input['business_id'] = $business_id;
      $input['created_by'] = $request->session()->get('user.id');

      if ($this->moduleUtil->isModuleInstalled('Repair')) {
        $input['use_for_repair'] = !empty($request->input('use_for_repair')) ? 1 : 0;
      }

      $brand = Brands::create($input);
      $output = [
        'success' => true,
        'data' => $brand,
        'msg' => __("brand.added_success")
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

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    if (!auth()->user()->can('brand.update')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      $business_id = request()->session()->get('user.business_id');
      $brand = Brands::where('business_id', $business_id)->find($id);

      $is_repair_installed = $this->moduleUtil->isModuleInstalled('Repair');

      return view('brand.edit')
        ->with(compact('brand', 'is_repair_installed'));
    }
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
    if (!auth()->user()->can('brand.update')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      try {
        $input = $request->only(['name', 'description']);
        $business_id = $request->session()->get('user.business_id');

        $brand = Brands::where('business_id', $business_id)->findOrFail($id);
        $brand->name = $input['name'];
        $brand->description = $input['description'];

        if ($this->moduleUtil->isModuleInstalled('Repair')) {
          $brand->use_for_repair = !empty($request->input('use_for_repair')) ? 1 : 0;
        }

        $brand->save();

        $output = [
          'success' => true,
          'msg' => __("brand.updated_success")
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
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (!auth()->user()->can('brand.delete')) {
      abort(403, 'Unauthorized action.');
    }

    if (request()->ajax()) {
      try {
        $business_id = request()->user()->business_id;

        $brand = Brands::where('business_id', $business_id)->findOrFail($id);
        $brand->delete();

        $output = [
          'success' => true,
          'msg' => __("brand.deleted_success")
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

  public function getBrandsApi()
  {
    try {
      $api_token = request()->header('API-TOKEN');

      $api_settings = $this->moduleUtil->getApiSettings($api_token);

      $brands = Brands::where('business_id', $api_settings->business_id)
        ->get();
    } catch (\Exception $e) {
      \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

      return $this->respondWentWrong($e);
    }

    return $this->respond($brands);
  }
}