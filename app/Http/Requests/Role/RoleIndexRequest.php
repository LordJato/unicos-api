<?php

namespace App\Http\Requests\Role;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ApiFormRequest;

class RoleIndexRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('view-all-role');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'min:3'],
            'offset' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
            'orderBy' => ['nullable', 'string'],
            'orderDesc' => ['nullable', 'boolean'],
            'withPermission' => ['nullable', 'boolean'],
        ];
    }
}
