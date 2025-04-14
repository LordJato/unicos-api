<?php

namespace App\Http\Requests\v1\Recruitment\Opportunity;

use Illuminate\Foundation\Http\FormRequest;

class CreateOpportunityRequest extends FormRequest
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
            'company_id' => ['required', 'integer', 'exists:companies,id'],
            'opportunity_type_id' => ['required', 'integer', 'exists:opportunity_types,id'],
            'opportunity_status_id' => ['required', 'integer', 'exists:opportunity_statuses,id'],
            'designation_id' => ['required', 'integer', 'exists:designations,id'],
            'career_level_id' => ['required', 'integer', 'exists:career_levels,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:opportunities,slug'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'schedule' => ['required', 'string', 'max:255'],
            'years_of_experience' => ['required', 'integer', 'min:0'],
            'vacancy' => ['required', 'integer', 'min:1'],
        ];
    }
}
