<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'       => ['required', 'max:256'],
            'description' => ['required'],
            'content'     => ['required'],
            'image'       => ['image', 'mimes:jpg,jpeg,png', 'mimetypes:image/jpeg,image/png'],
            'category_id' => ['required'],
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
            'title'       => 'Title',
            'description' => 'Description',
            'content'     => 'Content',
            'image'       => 'Image',
            'category_id' => 'Category',
        ];
    }
}
