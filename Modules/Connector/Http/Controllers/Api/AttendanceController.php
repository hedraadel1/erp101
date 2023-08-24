<?php

namespace Modules\Connector\Http\Controllers\Api;

use App\Agent;
use App\AgentDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Connector\Transformers\CommonResource;
use App\Business;
use App\Errand;
use App\SupervisorUser;
use App\User;
use App\Utils\ModuleUtil;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Modules\Essentials\Notifications\SupervisorNotififcation;

/**
 * @group Attendance management
 * @authenticated
 *
 * APIs for managing attendance
 */
class AttendanceController extends ApiController
{
	/**
     * All Utils instance.
     *
     */
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Get Attendance
     *
     * @urlParam user_id required id of the user Example: 1
     * @response {
		    "data": {
		        "id": 4,
		        "user_id": 1,
		        "business_id": 1,
		        "clock_in_time": "2020-09-12 13:13:00",
		        "clock_out_time": "2020-09-12 13:15:00",
		        "essentials_shift_id": 3,
		        "ip_address": null,
		        "clock_in_note": "test clock in from api",
		        "clock_out_note": "test clock out from api",
		        "created_at": "2020-09-12 13:14:39",
		        "updated_at": "2020-09-12 13:15:39"
		    }
		}
     */
	public function getAttendance($user_id)
	{
		if (!$this->moduleUtil->isModuleInstalled('Essentials')) {
			abort(403, 'Unauthorized action.');
		}

		$user = Auth::user();
        $business_id = $user->business_id;

		$attendance = \Modules\Essentials\Entities\EssentialsAttendance::where('business_id', $business_id)
                                    ->where('user_id', $user_id)
                                    ->orderBy('clock_in_time', 'desc')
                                    ->first();

        return new CommonResource($attendance);
	}

	/**
	 * Clock In
     *
     * [User must have "essentials.allow_users_for_attendance_from_api" permission to Clock in]
     *
     * @bodyParam user_id integer required id of the user Example: 1
     * @bodyParam clock_in_time string Clock in time.If not given current date time will be used Fromat: Y-m-d H:i:s Example:2000-06-13 13:13:00
     * @bodyParam clock_in_note string Clock in note.
     * @bodyParam ip_address string IP address.
     * @bodyParam latitude string Latitude of the clock in location.
     * @bodyParam longitude string Longitude of the clock in location.
     *
     * @response {
     	"success":true,
     	"msg":"Clocked In successfully",
     	"type":"clock_in"
     }
     */
	public function clockin(Request $request)
  {
    	if (!$this->moduleUtil->isModuleInstalled('Essentials')) {
			abort(403, 'Unauthorized action.');
		 }

        try {
        	$user = Auth::user();
        	$business_id = $user->business_id;
        	$business = Business::findOrFail($business_id);
        	$settings = $business->essentials_settings;
        	$settings = !empty($settings) ? json_decode($settings, true) : [];
            $essentialsUtil = new \Modules\Essentials\Utils\EssentialsUtil;

        	$data = [
                    'business_id' => $business_id,
                    'user_id' => $request->input('user_id'),
                    'clock_in_time' => empty($request->input('clock_in_time')) ?\Carbon::now() : $request->input('clock_in_time'),
                    'clock_in_note' => $request->input('clock_in_note'),
                    'ip_address' => $request->input('ip_address'),
                ];
                $user = User::findOrFail($request->user_id);
                if (!empty($user->zone_id)) {
                  $zone = Zone::where('id',$user->zone_id)->first();
                  $lat1 = $zone->zone_lat;
                  $lon1 = $zone->zone_long;
                  $lat2 = $request->input('latitude');
                  $lon2 = $request->input('longitude');
                  $dist = $this->twopoints_on_earth($lat1, $lon1 , $lat2, $lon2);

                   // dd($dist);
                if($dist > $zone->max_away){
                  $output = ['success' => false,
                    'msg' => 'لا يمكنك تسجيل الدخول انت خارج النطاق المحدد',
                    'type' => 'clock_in'
                ];
                return $this->respond($output);
                }
                }
               
            if (!empty($settings['is_location_required'])) {
                $long = $request->input('longitude');
                $lat = $request->input('latitude');

                if (empty($long) || empty($lat)) {
                    throw new \Exception("Latitude and longitude are required");
                }

                

                $response = $essentialsUtil->getLocationFromCoordinates($lat, $long);

                if (!empty($response) && isset($response['results'][0]['formatted_address'])) {
                    $data['clock_in_location'] = $response['results'][0]['formatted_address'];
                }
            }

            $output = $essentialsUtil->clockin($data, $settings);

            if ($output['success']) {
            	return $this->respond($output);
            } else {
            	return $this->otherExceptions($output['msg']);
            }
        	
        } catch (\Exception $e) {

            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            return $this->otherExceptions($e);
        }
  }

    /**
	 * Clock Out
     *
     * [User must have "essentials.allow_users_for_attendance_from_api" permission to Clock out]
     *
     * @bodyParam user_id integer required id of the user Example: 1
     * @bodyParam clock_out_time string Clock out time.If not given current date time will be used Fromat: Y-m-d H:i:s Example:2000-06-13 13:13:00
     * @bodyParam clock_out_note string Clock out note.
     * @bodyParam latitude string Latitude of the clock out location.
     * @bodyParam longitude string Longitude of the clock out location.
     *
     * @response {
     	"success":true,
     	"msg":"Clocked Out successfully",
     	"type":"clock_out"
     }
     */
    public function clockout(Request $request)
    {
    	if (!$this->moduleUtil->isModuleInstalled('Essentials')) {
			abort(403, 'Unauthorized action.');
		 }

        try {
        	$user = Auth::user();
        	$business_id = $user->business_id;
        	$business = Business::findOrFail($business_id);
        	$settings = $business->essentials_settings;
        	$settings = !empty($settings) ? json_decode($settings, true) : [];

        	$data = [
                'business_id' => $business_id,
                'user_id' => $request->input('user_id'),
                'clock_out_time' => empty($request->input('clock_out_time')) ?\Carbon::now() : $request->input('clock_out_time'),
                'clock_out_note' => $request->input('clock_out_note')
            ];
            $user = User::findOrFail($request->user_id);
            if (!empty($user->zone_id)) {
              $zone = Zone::where('id',$user->zone_id)->first();
              $lat1 = $zone->zone_lat;
              $lon1 = $zone->zone_long;
              $lat2 = $request->input('latitude');
              $lon2 = $request->input('longitude');
              $dist =  $this->twopoints_on_earth($lat1, $lon1 , $lat2, $lon2);

              if($dist > $zone->max_away){
                $output = ['success' => false,
                  'msg' => 'لا يمكنك تسجيل الخروج انت خارج النطاق المحدد',
                  'type' => 'clock_in'
              ];
              return $this->respond($output);
              }
            }
           
            $essentialsUtil = new \Modules\Essentials\Utils\EssentialsUtil;

            if (!empty($settings['is_location_required'])) {
                $long = $request->input('longitude');
                $lat = $request->input('latitude');

                if (empty($long) || empty($lat)) {
                    throw new \Exception("Latitude and longitude are required");
                }
                
                $response = $essentialsUtil->getLocationFromCoordinates($lat, $long);

                if (!empty($response) && isset($response['results'][0]['formatted_address'])) {
                    $data['clock_out_location'] = $response['results'][0]['formatted_address'];
                }
            }

            $output = $essentialsUtil->clockout($data, $settings);

            if ($output['success']) {
            	return $this->respond($output);
            } else {
            	return $this->otherExceptions($output['msg']);
            }
        	
        } catch (\Exception $e) {

            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
        	return $this->otherExceptions($e);
        }
    }

    /**
     * List Holidays
     * @queryParam location_id id of the location Example: 1
     * @queryParam start_date format:Y-m-d Example: 2020-06-25
     * @queryParam end_date format:Y-m-d Example: 2020-06-25
     *
     * @response {
            "data": [
                {
                    "id": 2,
                    "name": "Independence Day",
                    "start_date": "2020-08-15",
                    "end_date": "2020-09-15",
                    "business_id": 1,
                    "location_id": null,
                    "note": "test holiday",
                    "created_at": "2020-09-15 11:25:56",
                    "updated_at": "2020-09-15 11:25:56"
                }
            ]
        }
     */
    public function getHolidays()
    {
        if (!$this->moduleUtil->isModuleInstalled('Essentials')) {
            abort(403, 'Unauthorized action.');
        }

        $user = Auth::user();
        $business_id = $user->business_id;

        $query = \Modules\Essentials\Entities\EssentialsHoliday::where('business_id', $business_id);

        $permitted_locations = $user->permitted_locations($business_id);
        if ($permitted_locations != 'all') {
            $query->where(function ($q) use ($permitted_locations) {
                $q->whereIn('location_id', $permitted_locations)
                    ->orWhereNull('location_id');
            });
        }

        if (!empty(request()->input('location_id'))) {
                $query->where('location_id', request()->input('location_id'));
            }

        if (!empty(request()->start_date) && !empty(request()->end_date)) {
            $start = request()->start_date;
            $end =  request()->end_date;
            $query->whereDate('start_date', '>=', $start)
                        ->whereDate('start_date', '<=', $end);
        }
        $holidays = $query->get();

        return new CommonResource($holidays);
    }


    
    /**
     * Clock in / Clock out the logged in user.
     * @return Response
     */
    public function checkUserLocation(Request $request)
   {
    $user = User::findOrFail($request->user_id);
    if (!empty($user->zone_id)) {
      $mission = Errand::where('user_id' , $user->id)->latest()->first();
      if($mission){

        $date_time_now = Carbon::now()->format('d-m-Y H:i');
        if($date_time_now >= $mission->date_time_from && $date_time_now <= $mission->date_time_to){
          $output = ['success' => true,
          'mission' => ['from'=>$mission->date_time_from , 'to' =>$mission->date_time_to],
          'msg' => 'يوجد  تصريح بالخروج خارج النطاق',
        ];
          return $this->respond($output);

        }

      }
      $zone = Zone::where('id',$user->zone_id)->first();
      $lat1 = $zone->zone_lat;
      $lon1 = $zone->zone_long;
      $lat2 = $request->input('latitude');
      $lon2 = $request->input('longitude');
      $dist =  $this->twopoints_on_earth($lat1, $lon1 , $lat2, $lon2);
      if($dist > $zone->max_away){
        $output = ['success' => false,'msg' => ' خارج النطاق المحدد',];
      }
      $supervisor_ids = SupervisorUser::where('user_id' , $user->id)->pluck('supervisor_id')->toArray();
      $supervisors = User::whereIn('id' , $supervisor_ids)->get();

      foreach ($supervisors as $supervisor) {
        Notification::route('mail',[$supervisor->email =>$supervisor->getUserFullNameAttribute()])->notify( new SupervisorNotififcation($user));
      }
      $this->storeLoctionDetails($request->all());
     return $this->respond($output);
    }else{
      $output = ['success' => true,
        'msg' => ' داخل النطاق المحدد',
    ];
    return $this->respond($output);
    }
   }


  private function twopoints_on_earth($latitudeFrom, $longitudeFrom, $latitudeTo,  $longitudeTo)
  {
           $long1 = deg2rad($longitudeFrom);
           $long2 = deg2rad($longitudeTo);
           $lat1 = deg2rad($latitudeFrom);
           $lat2 = deg2rad($latitudeTo);
             
           //Haversine Formula
           $dlong = $long2 - $long1;
           $dlati = $lat2 - $lat1;
             
           $val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);
             
           $res = 2 * asin(sqrt($val));
             
           $radius = 3958.756;
             
           return ($res*$radius);
      }
 

      public function storeLoctionDetails($inputs){
        $agent = Agent::where('user_id',$inputs['user_id'])->first();
        if (!empty($agent)) {
          $details = AgentDetails::where('agent_id',$agent->id)->latest()->first();
          $agent_details =[
          'agent_id' => $agent->id,
          'action' => date('Y-m-d H:m:i'),
          // 'battery_check' => $inputs['battery_check'],
          'is_attendace_location' =>1,
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
        
        }
      }
}