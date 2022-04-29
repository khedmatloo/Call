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
        ];
    }

    public function messages()
    {
        return [
            'category.required' => 'موضوع انتخاب نشده است.',
            'subcategory.required' => 'زیرموضوع انتخاب نشده است.'
        ];
    }
}
