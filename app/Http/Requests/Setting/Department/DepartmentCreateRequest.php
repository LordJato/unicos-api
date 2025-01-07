<?php

namespace App\Http\Requests\Setting\Department;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ApiFormRequest;

class DepartmentCreateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create-department');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', 'unique:departments'],
        ];
    }
}
