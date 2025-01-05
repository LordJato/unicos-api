<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create-user');
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
