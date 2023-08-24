<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        
        $user = User::where('remember_token', $token)->first();
 
        if ($user && $token) {
            Auth::login($user);
            return $next($request);
        }
        else { 
            return response("unauthenticated", 401);
        }
    }
}
