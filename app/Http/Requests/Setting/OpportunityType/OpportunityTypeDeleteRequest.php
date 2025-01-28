<?php

namespace App\Http\Requests\Setting\OpportunityType;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ApiFormRequest;

class OpportunityTypeDeleteRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('delete-opportunity-type');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer']
        ];
    }
}
