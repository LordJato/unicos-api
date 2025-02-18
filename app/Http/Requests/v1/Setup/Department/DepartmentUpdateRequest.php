<?php

namespace App\Http\Requests\Setup\Department;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ApiFormRequest;

class DepartmentUpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update-department');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('departments')->ignore($this->id, 'id')],
        ];
    }
}
