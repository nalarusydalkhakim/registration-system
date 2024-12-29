<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|min:6|max:30',
            'status' => 'required|in:Belum Aktif,Aktif,Diblokir',
            'avatar' => 'sometimes|image|max:5000',
            'roles' => 'sometimes|array',
            'roles.*' => 'sometimes|exists:roles,name'
        ];
    }
}
