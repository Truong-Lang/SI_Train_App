<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
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
            'permission' => [
                'required',
                'max:255',
                Rule::unique('permissions')->where(fn($query) => $query->where('role_id',
                    $this->role_id)->whereNull('deleted_at'))->ignore($this->id ?? null)
            ],
            'role_id'    => ['required'],
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
            'permission' => 'Permission',
            'role_id'    => 'Role'
        ];
    }
}
