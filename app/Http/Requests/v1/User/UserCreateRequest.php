<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\v1\ApiFormRequest;
use App\Models\User;

class UserCreateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'account_id' => ['nullable', 'integer'],
            'email' => ['required', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'phone'    => ['nullable', 'max:100', 'unique:users'],
        ];
    }
}
