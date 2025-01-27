<?php

namespace App\Http\Requests\validator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateValidatorRequest extends FormRequest
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
            'gender' => 'required|string',
            'dob' => 'required|date|before_or_equal:' . now()->subYears(18)->toDateString(),
            'remarks' => 'required|string',
            'status' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'gender.required' => 'The gender field is required.',
            'gender.string' => 'The gender must be a valid string.',
            'dob.required' => 'The date of birth is required.',
            'dob.date' => 'The date of birth must be a valid date.',
            'dob.before_or_equal' => 'The date of birth must indicate an age of at least 18 years.',
            'remarks.required' => 'The remarks field is required.',
            'remarks.string' => 'The remarks must be a valid string.',
            'status.string' => 'The status must be a valid string.',
        ];
    }
}
