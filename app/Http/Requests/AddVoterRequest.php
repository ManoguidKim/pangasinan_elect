<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddVoterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fname' => 'required|string',
            'mname' => 'required|string',
            'lname' => 'required|string',
            'suffix' => 'nullable|string',
            'dob' => 'required|date|before_or_equal:' . now()->subYears(18)->toDateString(),
            'gender' => 'required|string',
            'barangay' => 'required|string',
            'precinct_no' => 'required|string',
            'remarks' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'fname.required' => 'First name is required.',
            'fname.string' => 'First name must be a string.',
            'mname.required' => 'Middle name is required.',
            'mname.string' => 'Middle name must be a string.',
            'lname.required' => 'Last name is required.',
            'lname.string' => 'Last name must be a string.',
            'suffix.string' => 'Suffix must be a string.',
            'dob.required' => 'Date of birth is required.',
            'dob.date' => 'Date of birth must be a valid date.',
            'dob.before_or_equal' => 'You must be at least 18 years old to register.',
            'gender.required' => 'Gender is required.',
            'gender.string' => 'Gender must be a string.',
            'barangay.required' => 'Barangay is required.',
            'barangay.string' => 'Barangay must be a string.',
            'precinct_no.required' => 'Precinct number is required.',
            'precinct_no.string' => 'Precinct number must be a string.'
        ];
    }
}
