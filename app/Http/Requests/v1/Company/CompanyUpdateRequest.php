<?php

namespace App\Http\Requests\v1\Company;

use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\v1\ApiFormRequest;

class CompanyUpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Company::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', Rule::unique('companies')->ignore($this->id, 'id')],
        ];
    }
}
