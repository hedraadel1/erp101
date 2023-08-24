<?php

namespace  Modules\Connector\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'     => 'required',
            'action'     => 'nullable',
            'battery_check'  => 'required',
            'mobile_status' => 'required',
            "longitude" => "required",
            "latitude" => "required",
        ];
    }

    public function messages()
    {
        return [
            'required'      => __('message.field is required'),
        ];
    }
}
