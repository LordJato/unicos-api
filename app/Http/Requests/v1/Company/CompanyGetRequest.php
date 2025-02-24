<?php

namespace App\Http\Requests\v1\Company;

use App\Models\Company;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\v1\ApiFormRequest;

class CompanyGetRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('view', Company::class);
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
