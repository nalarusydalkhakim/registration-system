<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,'.$this->user->id,
            'password' => 'sometimes|confirmed|string|min:6|max:30',
            'status' => 'sometimes|in:Belum Aktif,Aktif,Diblokir',
            'avatar' => 'sometimes|image|max:5000',
            'roles' => 'sometimes|array',
            'roles.*' => 'sometimes|exists:roles,name'
            
        ];
    }
}
