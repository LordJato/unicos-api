<?php

namespace App\Http\Requests\v1\Auth;

use App\Http\Requests\v1\ApiFormRequest;

class ResetPasswordRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:100'],
            "token" => ['required', 'email', 'max:100', 'unique:users'],
            'password' => ['required','min:6','confirmed'],
        ];
    }
}
