<?php

namespace App\Http\Middleware;

use Closure;

class SettingPassword
{
  public function handle($request, Closure $next)
  {   
  $password_settings = json_decode(session('business.password_settings'),true);
      if($request->is('business/settings')){
        if (isset($password_settings['enable_password_for_setting'] ) && $password_settings['enable_password_for_setting'] != null) {
          // return view('layouts.partials.confirm_password');
        }
        return $next($request);
      }
  
      // session(["current-page"=>$request->route('url')]);
      // return redirect()->route('gate');
  }
}
