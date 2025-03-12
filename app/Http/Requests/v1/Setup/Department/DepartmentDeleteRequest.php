<?php

namespace App\Http\Requests\v1\Setup\Department;

use App\Models\Setup\Department;
use App\Http\Requests\v1\ApiFormRequest;

class DepartmentDeleteRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('delete', Department::class);
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
