<?php

namespace App\Http\Requests\Barangay;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddBarangayRequest extends FormRequest
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
            'barangay' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'barangay.required' => 'The barangay field is required.',
            'barangay.string' => 'The barangay field must be a valid string.',
        ];
    }
}
