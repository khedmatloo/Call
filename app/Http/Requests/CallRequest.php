<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'category' => 'required',
            'subcategory' => 'required',
            'user_id' => '',
            'user_type' => '',
            'admin_id' => '',
            'order_id' => '',
            'description' => ''

        ];
    }
}
