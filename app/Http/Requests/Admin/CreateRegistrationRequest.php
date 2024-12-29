<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRegistrationRequest extends BaseRequest
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
            // User
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|confirmed|string|min:6|max:30',
        
            // Student
            'phone' => 'required|string|max:15',
            'zip_code' => 'required|string|max:10',
            'address' => 'required|string|max:500',
            'date_of_birth' => 'required|date',
            'place_of_birth' => 'required|string|max:255',
        
            // Registration
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:active,inactive,pending',
        
            // Registration Grade
            'grades' => 'required|array|min:1',
            'grades.*.course_id' => 'required||exists:courses,id',
            'grades.*.grade' => 'required|numeric|min:0|max:100',
        ];
    }
}
