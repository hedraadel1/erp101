<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LoadingPageMiddleware
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
      $view = view('layouts.loadingpage');

      // Log the type of the $response object before the middleware is executed.
      Log::info('Response type before: ' . gettype($response));

      // Render the view object to a response object.
      $response = $view->render();

      // Log the type of the $response object after the middleware is executed.
      Log::info('Response type after: ' . gettype($response));

      return $response;
    }
}