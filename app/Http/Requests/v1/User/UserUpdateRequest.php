<?php

namespace App\Http\Requests\v1\User;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\v1\ApiFormRequest;

class UserUpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update-user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($this->id, 'id')],
        ];
    }
}
