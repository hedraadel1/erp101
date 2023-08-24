<?php

namespace App\Http\Controllers;

use App\Agent;
use App\AgentDetails;
use App\BusinessLocation;
use App\User;
use App\Zone;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ZoneController extends Controller
{

  public function index(Request $request)
  {
   if (request()->ajax()) {
    $business_id = request()->session()->get('user.business_id');
    
      $query = Zone::where('business_id' , $business_id);
      $zones = $query->latest()->get();
      // dd($zones);
      return DataTables::of($zones)
        ->addColumn(
            'action',
            function ($row) {
              $html ='';
              // if (auth()->user()->can('unit.update')) {
              $html .='<button data-href="'.action('ZoneController@edit', [$row->id]).'" class="btn Btn-Brand Btn-bx  Btn-Primary edit_zone_button"><i class="glyphicon glyphicon-edit"></i>'. __("messages.edit").'</button>&nbsp;';
               
              // }
              // if (auth()->user()->can('unit.delete')) {
                  $html .='<button data-href="'.action('ZoneController@destroy', [$row->id]).'" class="btn Btn-Brand Btn-bx  btn-danger delete_zone_button"><i class="glyphicon glyphicon-trash"></i>'. __("messages.delete").'</button>&nbsp;';
                  $html .='<a href="#" data-href="' . action('ZoneController@getAssignUsers', [$row->id]) . '" data-container="#user_zone_modal" class="btn-modal btn Btn-Brand btn-sm  btn-success"><i class="fas fa-users" aria-hidden="true"></i> ' . __("essentials::lang.assign_users") . '</a>';
              // }
              return $html;
            
            }
          )
         
        ->removeColumn('id')
        ->rawColumns(['action'])
        ->make(true);
  
   }
    return view('zones.index');
  }

  
  public function create()
  {
      // if (!auth()->user()->can('unit.create')) {
      //     abort(403, 'Unauthorized action.');
      // }
      return view('zones.create');
  
  }

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!auth()->user()->can('unit.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $input = $request->only(['max_away','zone_name', 'zone_lat', 'zone_long']);
            $input['business_id'] = $request->session()->get('user.business_id');
            // $input['created_by'] = $request->session()->get('user.id');

           

            $zone = Zone::create($input);
            $output = ['success' => true,
                        'data' => $zone,
                        'msg' => __("lang_v1.done")
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (!auth()->user()->can('unit.update')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $zone = Zone::where('business_id', $business_id)->find($id);
            return view('zones.edit')->with(compact('zone'));
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
        if (!auth()->user()->can('unit.update')) {
            abort(403, 'Unauthorized action.');
        }

        // if (request()->ajax()) {
            try {
              $input = $request->only(['max_away','zone_name', 'zone_lat', 'zone_long']);
              $business_id = $request->session()->get('user.business_id');

                $zone = Zone::where('business_id', $business_id)->findOrFail($id);
               $zone->update($input);
                $output = ['success' => true,
                            'msg' => __("unit.updated_success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return back()->with(['status'=>$output]);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (!auth()->user()->can('unit.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;

                $zone = Zone::where('business_id', $business_id)->findOrFail($id);

                $zone->delete();
                $output = ['success' => true,
                        'msg' => __("unit.deleted_success")
                        ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => '__("messages.something_went_wrong")'
                        ];
            }

            return $output;
        }
    }


    public function getAssignUsers($zone_id)
    {
        $business_id = request()->session()->get('user.business_id');

        
        $zone = Zone::where('business_id', $business_id)
                    ->with(['users'])
                    ->findOrFail($zone_id);

        $users = User::forDropdown($business_id, false);


        $user_zones = [];

        if (!empty($zone->users)) {
            foreach ($zone->users as $user) {
                $user_zones[$user->id] = [

                  'id'=>$user->id
                ];
            }
        }
        // $user_shift_ids = EssentialsUserShift::pluck('user_id')->toArray();
        
        return view('zones.add_shift_users')
                ->with(compact('zone', 'users','user_zones' ));
    }
    public function postAssignUsers(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        // $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

        // if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module')) && !$is_admin) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $zone_id = $request->input('zone_id');
            $users = User::where('business_id', $business_id)
                        ->where('zone_id', $zone_id)->update(['zone_id'=> null]);
// dd($request->user_zone);
            foreach ($request->user_zone as $key => $value) {
              $user = User::where('id',$key)->first();
              $user->zone_id = $zone_id;
              $user->save();
            }

            
            $output = ['success' => true,
                            'msg' => __("lang_v1.added_success")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")

                        ];
        }

        return back()->with(['status'=>$output]);
    }
}