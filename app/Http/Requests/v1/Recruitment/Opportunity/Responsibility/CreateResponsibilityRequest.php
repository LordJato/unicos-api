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
        return true; // Ensure this matches your authorization logic
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
                Rule::exists('opportunities', 'id')
                    ->where('is_active', true) // Optional: only allow active opportunities
            ],
            'description' => [
                'required',
                'string',
                'min:10',    // Minimum description length
                'max:2000'   // Maximum description length
            ],
            'order' => [    // Optional: if you need ordering
                'sometimes',
                'integer',
                'min:0'
            ]
        ];
    }

    /**
     * Prepare the data for validation (optional)
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'description' => trim($this->description) // Clean up whitespace
        ]);
    }

    /**
     * Custom validation messages (optional)
     */
    public function messages()
    {
        return [
            'opportunity_id.exists' => 'The selected opportunity is invalid or not active.',
            'description.required' => 'Responsibility description is required.',
            'description.min' => 'Description should be at least 10 characters.'
        ];
    }
}