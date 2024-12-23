<?php

namespace App\Http\Requests\Setting\Department;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Gate;

class DepartmentGetRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('view-department');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'id' => ['required', 'integer', 'exists:departments,id'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    { 
        $this->merge([
            'id' => $this->query('id'),
        ]);
    }
}
