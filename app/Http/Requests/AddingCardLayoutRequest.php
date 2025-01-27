<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddingCardLayoutRequest extends FormRequest
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
            'cardFile' => 'required|file|mimes:jpeg,jpg,png|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'cardFile.required' => 'The card is required.',
            'cardFile.file' => 'The file must be a valid file.',
            'cardFile.mimes' => 'The file must be a type of: jpeg, jpg, png.',
            'cardFile.max' => 'The file size must not exceed 1MB.',
        ];
    }
}
