<?php

namespace App\Http\Requests\v1\Recruitment\Opportunity\Benefit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBenefitRequest extends FormRequest
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
            'opportunity_id' => [
                'sometimes', // Only validate if the field is present
                'integer',
                'exists:opportunities,id',
            ],
            'description' => [
                'sometimes', // Only validate if the field is present
                'string',
                'max:255',
            ],
        ];
    }
}
