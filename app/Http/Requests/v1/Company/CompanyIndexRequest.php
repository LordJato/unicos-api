<?php

namespace App\Http\Requests\v1\Company;

use App\Models\Company;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\v1\ApiFormRequest;

class CompanyIndexRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Company::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'min:3', 'max:100'],
            'offset' => ['nullable', 'integer', 'min:0'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'orderBy' => ['nullable', 'string', 'in:id,name'],
            'orderDesc' => ['nullable', 'string'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'search' => $this->input('search', null),
            'offset' => (int)$this->input('offset') ?? 0,
            'limit' => !empty($this->input('limit')) ? (int)$this->input('limit') : 10,
            'orderBy' => $this->input('orderBy') ?? 'id',
            'orderDesc' => $this->input('orderDesc') === 'true' ? 'desc' : 'asc',
        ]);
    }
}
