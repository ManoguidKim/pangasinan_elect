<?php

namespace App\Http\Requests\systemadmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateMunicipalityRequest extends FormRequest
{
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
            'municipality' => 'required|string',
            'district' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'municipality.required' => 'The municipality field is required.',
            'municipality.string' => 'The municipality field must be a valid string.',

            'district.required' => 'The district field is required.',
            'district.string' => 'The district field must be a valid string.'
        ];
    }
}
