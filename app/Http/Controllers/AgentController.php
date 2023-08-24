<?php

namespace App\Http\Controllers;

use App\Agent;
use App\AgentDetails;
use App\BusinessLocation;
use App\Errand;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgentController extends Controller
{

  public function index(Request $request)
  {
    $business_id = $request->session()->get('user.business_id');
    $agents = Agent::with('agentDetails')->where('business_id', $business_id)->get();
    $business_locations = BusinessLocation::forDropdown($business_id, true);
    
    return view('agents.index')->with(compact('agents', 'business_locations'));
  }


  public  function getdata()
  {
    $business_id = request()->session()->get('user.business_id');
    
      $query = Agent::where('agents.business_id' , $business_id);
     //filter by agent
    if (request()->agent) {
      $query->where('id',request()->agent);
    }
     //filter by location_id
    // if (request()->location_id) {
    //   $query->where('',request()->location_id);
    // }
      $agents = $query->latest();
      return DataTables::of($agents)
          ->addColumn(
              'action',
              function (Agent $agent) {
                  $html = '<span style="display: flex;justify-content: flex-start;">';
                  $html .= '<a class="btn btn-primary" style="margin:0px 5px; width: 120px!important; " href="'.route("agent.show", $agent->id).'">فحص</a> ' ;
                  if ($agent->user->zone_id != null) {
                    $html .='<a style="width: 120px!importan; t" href="#" data-href="' . action('AgentController@getErrandsTable', [$agent->id]) . '" data-container="#errands_table" class="btn-modal btn  btn-success"> تصريح خروج</a>';
                  }

                  return $html ;
              }
          )
          ->removeColumn('id')
          ->editColumn('user_id', function($row){
            return optional($row->user)->first_name . ' '.  optional($row->user)->last_name;
          })
          ->editColumn('business_id', function($row){
            return $row->getLocationName($row->user_id) ;
          })
          ->rawColumns(['action'])
          ->toJson();
  }
  public  function showDetails( $id)
  {
    $query  = AgentDetails::where('agent_id', $id);
     //filter by date
     if(request('start_date') && request('end_date')){
      $query->whereBetween('action', [request('start_date') , request('end_date')] );
    }
     if(request('is_moving') ){
      $is_moving = request('is_moving') == 'no'?'0':request('is_moving');
      $query->where('is_moving', $is_moving );
    }

    $agent = $query->latest();
      return DataTables::of($agent)
          ->addColumn(
              'role',
              function ($row) {
                  $html = '<span>';
                  
                  $html .= '<a class="btn btn-primary"  href="'.route("agent.show", $row->agent_id).'?lat='.$row->latitude .'&lng='.$row->longitude.'">أظهار الموقع</a> </span>' ;
                  return $html ;
              }
          )
          ->removeColumn('id')
          ->addColumn('user', function($row){
            return optional($row->agent)->user->first_name . ' '.  optional($row->agent)->user->last_name ;
          })
          ->editColumn('is_moving', function($row){
            return $row->is_moving == '0' ?'Yes' :'No';
          })
          
          ->rawColumns(['role'])
          ->toJson();
  }

  public function show(Agent $agent){
    $resource = $agent;
    $locaion = AgentDetails::where('agent_id',  $resource->id)->latest()->first();
    $last_latitude = '21.05456465';
    $last_longitude = '21.1254566';
   if ($locaion) {
    $last_latitude = $locaion->latitude;
    $last_longitude = $locaion->longitude;
   }
    return view('agents.show' , compact('resource' , 'last_latitude' , 'last_longitude'));
  }


  public function storeLocation(Request $request)
  {
    $user_id = auth()->user()->id;
    $agent = Agent::where('user_id',$user_id)->first();
    if (!empty($agent)) {
      $details = AgentDetails::where('agent_id',$agent->id)->latest()->first();
      // $ip = '49.35.41.195'; //For static IP address get
        $ip = request()->ip(); //Dynamic IP address get
      $data = \Location::get($ip);                
      // dd($data);
      $agent_details =[
        'agent_id' => $agent->id,
        'action' => date('Y-m-d H:m:i'),
        'battery_check' => 'good',
        'mobile_status' => 'good',
        'longitude' => $data->longitude,
        'latitude' => $data->latitude,
      ];
      if (!empty($details)) {
        if ($data->longitude == $details->longitude && $data->latitude == $details->latitude ) {
          $agent_details['is_moving']  = '0';
        }else{
          $agent_details['is_moving']  = '1';
        }
      }else{
        $agent_details['is_moving']  = '1';
      }
      // dd($agent_details);
       AgentDetails::create($agent_details);
      return  response()->json(['status'=> 200,'data'=>'done']);

    }else{
      return  response()->json(['status'=> 404,'data'=>'agent not found']);

    }
  }
  
  public function getErrandsTable(Agent $id)
  {
      $agent = $id;

      return view('agents.errand_model' , compact('agent'));  
  }


  public function postErrands(Request $request)
  {
      $inputs = $request->all();
      $inputs['date_time_from'] =Carbon::parse($inputs['date_time_from'])->format('d-m-Y H:i');
      $inputs['date_time_to'] =Carbon::parse($inputs['date_time_to'])->format('d-m-Y H:i');
      $inputs['business_id'] = session('business.id');
      try{
      Errand::create($inputs);
      $output = ['success' => true,'msg' => __("lang_v1.added_success")];

      } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")

                        ];
      }
        return back()->with(['status'=>$output]);
  
      }
}