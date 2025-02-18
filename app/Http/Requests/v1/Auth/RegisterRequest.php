<?php

namespace App\Http\Requests\v1\Auth;

use App\Http\Requests\v1\ApiFormRequest;
class RegisterRequest extends ApiFormRequest
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
            'accountTypeId' => ['required', 'numeric', 'max:1'],
            'name' => ['required', 'max:100', 'unique:accounts'],
            'email'    => ['required','email','max:100','unique:users'],
            'password' => ['required','min:6','confirmed'],
            'phone'    => ['max:100', 'unique:users'],
        ];
    }

    public function messages(): array
    {
        return [
            'accountTypeId' => 'Account Type is required'
        ];
    }
}
