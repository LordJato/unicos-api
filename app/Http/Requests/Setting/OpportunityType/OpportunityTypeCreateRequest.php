<?php

namespace App\Http\Requests\Setting\OpportunityType;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ApiFormRequest;

class OpportunityTypeCreateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create-opportunity-type');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'observance_type_id' => ['required', 'integer', 'max:1',],
            'title' => ['required', 'string', 'max:100', 'unique:observances'],
            'description' => ['required', 'string', 'max:200',],
            'start_date' => ['required', 'date', 'before:end_date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ];
    }
}
