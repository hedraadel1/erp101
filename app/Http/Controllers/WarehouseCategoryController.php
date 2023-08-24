<?php

namespace App\Http\Controllers;

use App\CustomerGroup;
use App\Utils\Util;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\SellingPriceGroup;
use App\User;
use App\UserGroup;
use App\WarehouseCategory;
use DB;
class WarehouseCategoryController extends Controller
{
    /**
       * Constructor
       *
       * @param Util $commonUtil
       * @return void
       */
    public function __construct(Util $commonUtil)
    {
        $this->commonUtil = $commonUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $warehouse_group = WarehouseCategory::where('business_id', $business_id)->get();                                

            return Datatables::of($warehouse_group)
                    ->addColumn(
                      'action',
                      function($row){
                        return '<button data-href="'.action('WarehouseCategoryController@edit', $row->id).'" class="btn Btn-Brand Btn-bx Btn-Primary   edit_warehouse_category_button" data-container=".warehouse_categories_modal"><i class="glyphicon glyphicon-edit"></i>'. __("messages.edit").'</button>
                            &nbsp;
                            <button data-href="'.action('WarehouseCategoryController@destroy', $row->id).'" class="btn Btn-Brand Btn-bx  btn-danger delete_warehouse_category_button"><i class="glyphicon glyphicon-trash"></i> '.__("messages.delete").'</button>';
                      }
                    )
                    ->removeColumn('id')
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('warehouse_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        return view('warehouse_categories.create');
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
            $input = $request->only(['name', 'description']);
            $input['business_id'] = $request->session()->get('user.business_id');
            $warehouse_group = WarehouseCategory::create($input);
          
            $output = ['success' => true,
                            'data' => $warehouse_group,
                            'msg' => __("lang_v1.success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

        return back()->with(['status'=>$output]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerGroup  $customerGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $warehouse_group = WarehouseCategory::where('business_id', $business_id)->find($id);

            return view('warehouse_categories.edit')->with(compact('warehouse_group'));
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
            try {
                $input = $request->only(['name', 'description']);
                $business_id = $request->session()->get('user.business_id');


                $warehouse_category = WarehouseCategory::where('business_id', $business_id)->findOrFail($id);

                $warehouse_category->update($input);
                $output = ['success' => true,
                            'msg' => __("lang_v1.success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return back()->with(['status'=>$output]);
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

                 WarehouseCategory::where('business_id', $business_id)->findOrFail($id)->delete();

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
