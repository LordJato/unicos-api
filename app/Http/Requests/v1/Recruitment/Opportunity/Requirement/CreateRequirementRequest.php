<?php

namespace App\Http\Requests\v1\Recruitment\Opportunity\Requirement;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequirementRequest extends FormRequest
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
                'required',
                'integer',
                'exists:opportunities,id',
            ],
            'description' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
