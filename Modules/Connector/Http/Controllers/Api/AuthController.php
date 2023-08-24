<?php

namespace Modules\Connector\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Unit;
use App\Product;
use App\User;
use Illuminate\Http\Request;

use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Essentials\Entities\EssentialsUserShift;

class AuthController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $commonUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
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
    public function login(Request $request)
    {
        $user = User::where('username',$request->username)->first();
        $credentials = $request->only('username', 'password');
        $user_shift = EssentialsUserShift::join('essentials_shifts as s', 's.id', '=', 'essentials_user_shifts.essentials_shift_id')
        ->where('user_id', $user->id)
        ->select( 's.name','s.start_time', 's.end_time', 's.type')
        ->first();
       
        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('access_token')->accessToken;
                return [
                    "status" => 1,
                    "message" => __('lang_v1.success'),
                    "user_id" => $user->id,
                    "name" => $user->first_name . ' ' . $user->last_name,
                    "user_shift" => $user_shift,
                    "token" => $token,
                ];
            }else{
                return [
                    "status" => 0,
                    "message" => __('lang_v1.no_attachment_found'),
                    "data" => [],
                ];
            }
            

        }else{
            return [
                "status" => 0,
                "message" => __('lang_v1.no_attachment_found'),
                "data" => [],
            ];
        }
        
    }

}
