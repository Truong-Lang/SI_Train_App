<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $category_id = $this->category_id;
        $id = $this->id;

        return [
            'title'       => ['required', 'max:256'],
            'alias'       => [
                'required',
                'max:256',
                Rule::unique('news')->where(fn($query) => $query->where('category_id', $category_id)
                    ->whereNull('deleted_at'))
                    ->ignore($id ?? null)
            ],
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
            'alias'       => 'Alias',
            'description' => 'Description',
            'content'     => 'Content',
            'image'       => 'Image',
            'category_id' => 'Category',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'alias.unique' => 'The Alias News of this category has already been taken. Please use another Title.'
        ];
    }
}
