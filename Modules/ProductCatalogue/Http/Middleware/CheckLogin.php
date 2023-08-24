<?php

namespace Modules\ProductCatalogue\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      
      $user = auth()->user();
      if (!$user) {
        return redirect(route('product_catalogue.login').'?business_id='. request()->business_id .'&location_id='.request()->location_id)->withErrors(__('lang.you_cannot_login'));
      } 

        return $next($request);
    }
}
