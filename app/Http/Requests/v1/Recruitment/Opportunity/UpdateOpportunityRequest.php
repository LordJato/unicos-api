<?php

namespace App\Http\Requests\v1\Recruitment\Opportunity;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOpportunityRequest extends FormRequest
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
        $opportunityId = $this->route('opportunity'); // Assuming route parameter is 'opportunity'

        return [
            'company_id' => ['sometimes', 'integer', 'exists:companies,id'],
            'opportunity_type_id' => ['sometimes', 'integer', 'exists:opportunity_types,id'],
            'opportunity_status_id' => ['sometimes', 'integer', 'exists:opportunity_statuses,id'],
            'designation_id' => ['sometimes', 'integer', 'exists:designations,id'],
            'career_level_id' => ['sometimes', 'integer', 'exists:career_levels,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('opportunities', 'slug')->ignore($opportunityId)
            ],
            'description' => ['sometimes', 'string'],
            'location' => ['sometimes', 'string', 'max:255'],
            'schedule' => ['sometimes', 'string', 'max:255'],
            'years_of_experience' => ['sometimes', 'integer', 'min:0'],
            'vacancy' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
