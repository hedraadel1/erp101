<?php

namespace  Modules\Connector\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocument extends FormRequest
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
            'task_id'     => 'required',
            'description'     => 'nullable',
            "documents" => "array|nullable",
        ];
    }

    public function messages()
    {
        return [
            'required'      => __('message.field is required'),
        ];
    }
}
