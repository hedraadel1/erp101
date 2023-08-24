<?php

namespace App\Http\Controllers;

use App\SupervisorUser;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;
use PhpOffice\PhpSpreadsheet\Style\Supervisor;

class SupervisorController extends Controller
{

  public function index(Request $request)
  {
   
    if (request()->ajax()) {
      $business_id = request()->session()->get('user.business_id');
      
        $query = User::where('business_id' , $business_id)->where('is_supervisor' , 1);
        $supervisors = $query->latest()->get();
        // dd($supervisors);
        return DataTables::of($supervisors)
          ->addColumn(
              'action',
              function ($row) {
                $html ='';
                $html .='<a href="#" data-href="' . action('SupervisorController@getAssignUsers', [$row->id]) . '" data-container="#user_modal" class="Btn-Brand btn-modal Btn-Primary btn--block-height25"><i class="fas fa-users" aria-hidden="true"></i> ' . __("essentials::lang.assign_users") . '</a>';
                return $html;
              
              }
            )
            ->editColumn('name' ,  function ( $row) {
              return $row->getUserFullNameAttribute();
            })
          ->removeColumn('id')
          ->rawColumns(['action'])
          ->make(true);
    
     }

    return view('supervisors.index');
  }


  public function getAssignUsers($user_id)
  {
      $business_id = request()->session()->get('user.business_id');

      
      $supervisor = User::where('business_id', $business_id)
                  ->with(['supervisor_users'])
                  ->findOrFail($user_id);
// dd($supervisor);
      $query = User::where('business_id', $business_id)->user();
      $all_users = $query->select('id', DB::raw("CONCAT(COALESCE(surname, ''),' ',COALESCE(first_name, ''),' ',COALESCE(last_name,'')) as full_name"))->get();
      $users = $all_users->pluck('full_name', 'id');
      $user_supervisor = [];
      if (!empty($supervisor->supervisor_users)) {
          foreach ($supervisor->supervisor_users as $user) {
              $user_supervisor[$user->user_id] = [

                'id'=>$user->user_id
              ];
          }
      }
      // dd($user_supervisor);

      // $user_shift_ids = EssentialsUserShift::pluck('user_id')->toArray();
      
      return view('supervisors.add_users')
              ->with(compact('supervisor', 'users','user_supervisor' ));
  }
  public function postAssignUsers(Request $request)
  {
      $business_id = request()->session()->get('user.business_id');
      // $is_admin = $this->moduleUtil->is_admin(auth()->user(), $business_id);

      // if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'essentials_module')) && !$is_admin) {
      //     abort(403, 'Unauthorized action.');
      // }

      try {
          $supervisor_id = $request->input('supervisor_id');
          // $shift = Shift::where('business_id', $business_id)
          //             ->find($zone_id);

          SupervisorUser::where('supervisor_id' , $supervisor_id)->delete() ;
          foreach ($request->user_supervisor as $key => $value) {
            $supervisor = User::where('id' , $key)->where('is_supervisor',1)->first();
            if ($supervisor) {
              SupervisorUser::create([
                'supervisor_id' =>$supervisor_id,
                'user_id' =>$key
              ]);
              if (count($supervisor->supervisor_users) > 0) {
               foreach ($supervisor->supervisor_users as $user){
                SupervisorUser::create([
                  'supervisor_id' =>$supervisor_id,
                  'user_id' =>$user->user_id
                ]);
               }
              }
            }else{
              SupervisorUser::create([
                'supervisor_id' =>$supervisor_id,
                'user_id' =>$key
              ]);
            }
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