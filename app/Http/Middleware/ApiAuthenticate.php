<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
class ApiAuthenticate 
{
    
    public function handle($request, Closure $next)
    {
        $token = $request->header('API-TOKEN');
        $is_api_settings_exists = User::where('api_token', $token)
                                            // ->where('shop_domain', $shop_domain)
                                            ->exists();

        if (!$is_api_settings_exists) {
            die('Invalid Request');
        }
        return $next($request);
    }
}
