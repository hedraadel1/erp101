<?php

namespace Modules\Connector\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Connector\Transformers\CommonResource;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\VarDumper\Cloner\Data;

class AutoResponderController extends ApiController
{


  public function store(Request $request)
  {

    $data = $request->json()->all();

    $message = $data['message'];
    $app = $data['app'];
    $sender = $data['sender'];

    // Process messages here

    // Set response code - 200 success
    http_response_code(200);


    return response()->json([
      'reply' => 
        'message' 
        
    ], '200');
  }
}