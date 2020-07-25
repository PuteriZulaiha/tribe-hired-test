<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePost extends FormRequest
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
            'id' => 'nullable|integer',
            'name' => 'nullable|string|max:225',
            'body' => 'nullable|string|max:225',
            'title' => 'nullable|string|max:225',
            'userId' => 'nullable|integer',
            'limit' => 'nullable|integer'
        ];
    }
}
