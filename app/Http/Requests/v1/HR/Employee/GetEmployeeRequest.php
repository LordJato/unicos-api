<?php

namespace App\Http\Requests\v1\HR\Employee;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\v1\ApiFormRequest;

class GetEmployeeRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('view-employee');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
           'id' => ['required', 'integer', 'exists:employees,id'],
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
