<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'user_id' => '',
            'call_id' => 'required',
            'admin_id' => '',
            'order_id' => '',
            'description' => ''
        ];
    }
    public function messages()
    {
        return [
            'call_id.required' => 'کامنت باید به یک تماس مرتبط باشد'
        ];
    }
}
