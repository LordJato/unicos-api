<?php

namespace App\Http\Requests\Setup\Department;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ApiFormRequest;

class DepartmentDeleteRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('delete-department');
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
