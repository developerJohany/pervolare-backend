<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Contracts\Validation\Validator;

class ValidationCategory extends FormRequest
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
            'code' => 'required|string|min:2|max:10',
            'title' => 'required|string|min:2|max:10',
            'description' => 'required|string|max:500',
            'id_parent_category' => 'nullable|integer',
        ];
    }
}
