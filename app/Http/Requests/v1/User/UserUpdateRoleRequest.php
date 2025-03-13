<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\v1\ApiFormRequest;
use App\Models\User;

class UserUpdateRoleRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userId' => ['required', 'integer', 'exists:users,id'],
            'roles' => ['required', 'array'],
        ];
    }

     /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'userId' => $this->query('userId'),
        ]);
    }
}
