<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['required', 'max:256'],
            'alias' => [
                'required',
                'max:256',
                Rule::unique('categories')->whereNull('deleted_at')->ignore($this->id ?? null)
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'  => 'Name',
            'alias' => 'Alias'
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'alias.unique' => 'The :attribute has already been taken. Please use another Title.'
        ];
    }
}
