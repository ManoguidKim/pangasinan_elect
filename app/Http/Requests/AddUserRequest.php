<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'email' => 'string|required',
            'password' => 'string|required',
            'municipality' => 'string|nullable',
            'barangay' => 'string|nullable',
            'role' => 'string|required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',

            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a valid string.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a valid string.',

            'municipality.string' => 'The municipality must be a valid string.',

            'barangay.string' => 'The barangay must be a valid string.',

            'role.required' => 'The role field is required.',
            'role.string' => 'The role must be a valid string.',
        ];
    }
}
