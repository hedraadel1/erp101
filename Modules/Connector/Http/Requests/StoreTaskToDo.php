<?php

namespace  Modules\Connector\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskToDo extends FormRequest
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
            'task'     => 'nullable',
            'description'     => 'nullable',
            'date'  => 'nullable',
            'estimated_hours' => 'nullable',
            "priority" => "nullable",
            "status" => "nullable",
            "end_date" => "nullable",
            "project_id" => "nullable",
            "users" => "array|nullable",
        ];
    }

    public function messages()
    {
        return [
            // 'required'      => __('message.field is required'),
        ];
    }
}
