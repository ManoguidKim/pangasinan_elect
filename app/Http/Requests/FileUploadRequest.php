<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
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
    public function rules()
    {
        return [
            'excelFile' => 'required|file|mimes:xlsx,xls|max:1024',
        ];
    }

    /**
     * Custom message for validation
     */
    public function messages()
    {
        return [
            'excelFile.required' => 'An Excel file is required.',
            'excelFile.mimes' => 'Only .xlsx or .xls files are allowed.',
            'excelFile.max' => 'The file size must not exceed 1MB.',
        ];
    }
}
