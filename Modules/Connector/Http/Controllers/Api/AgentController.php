<?php

namespace Modules\Connector\Http\Controllers\Api;

use App\Agent;
use App\AgentDetails;
use App\BusinessLocation;
use App\User;
use Illuminate\Support\Facades\Auth;
use Modules\Connector\Http\Requests\StoreAgentRequest;
use Modules\Connector\Transformers\AgentResource;
use Yajra\DataTables\Facades\DataTables;

class AgentController extends ApiController
{

  public function index()
    {
        $user = auth()->user();

        $business_id = $user->business_id;        
        $agents = Agent::with('agentDetails')->where('business_id', $business_id)->get();
        return AgentResource::collection($agents);
    }
  
  public function store(StoreAgentRequest $request)
  {
    $inputs = $request->validated();
    $agent = Agent::where('user_id',$inputs['user_id'])->first();
    if (!empty($agent)) {
      $details = AgentDetails::where('agent_id',$agent->id)->latest()->first();
      $agent_details =[
        'agent_id' => $agent->id,
        'action' => date('Y-m-d H:m:i'),
        'battery_check' => $inputs['battery_check'],
        'mobile_status' => $inputs['mobile_status'],
        'longitude' => $inputs['longitude'],
        'latitude' => $inputs['latitude'],
      ];
      if (!empty($details)) {
        if ($inputs['longitude'] == $details->longitude && $inputs['latitude'] == $details->latitude ) {
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


  
}