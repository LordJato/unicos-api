<?php

namespace App\Http\Requests\v1\Recruitment\Opportunity\Responsibility;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateResponsibilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Changed from false to true to allow access
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'opportunity_id' => [
                'required',
                'integer',
                'exists:opportunities,id'
            ],
            'description' => [
                'required',
                'string',
                'max:1000' // Added max length for description
            ],
        ];
    }
}