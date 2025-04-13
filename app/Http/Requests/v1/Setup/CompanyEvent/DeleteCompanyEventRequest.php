<?php

namespace App\Http\Requests\v1\Setup\CompanyEvent;

use App\Http\Requests\v1\ApiFormRequest;
use App\Models\Setup\CompanyEvent;

class DeleteCompanyEventRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', CompanyEvent::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }
}
