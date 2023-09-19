<?php

namespace Modules\Connector\Http\Controllers\Api;

use Illuminate\Validation\Validator;

class AutoResponderValidator extends Validator
{
  public function validateQuery(array $data)
  {
    return $this->validate($data, [
      'sender' => 'required|string',
      'message' => 'required|string',
    ]);
  }
}