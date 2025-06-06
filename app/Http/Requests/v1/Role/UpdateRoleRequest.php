<?php

namespace App\Http\Requests\v1\Role;

use App\Models\Role;
use Illuminate\Validation\Rule;
use App\Http\Requests\v1\ApiFormRequest;

class UpdateRoleRequest extends ApiFormRequest
{
    private $id;

    public function __construct()
    {
        $this->id = $this->route('roles'); // Assign the ID from the route to $this->id
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Role::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', Rule::unique('roles')->ignore($this->id, 'id')],
        ];
    }
}
