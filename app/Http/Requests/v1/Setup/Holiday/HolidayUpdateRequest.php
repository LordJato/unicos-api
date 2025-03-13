<?php

namespace App\Http\Requests\v1\Setup\Department;

use App\Models\Setup\Holiday;
use Illuminate\Validation\Rule;
use App\Http\Requests\v1\ApiFormRequest;

class DepartmentUpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Holiday::class);
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
