<?php

namespace App\Http\Requests\Company;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create-company');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', 'unique:companies'],
            'address' => ['required', 'string', 'min:8', 'max:150'],
            'city' => ['required', 'string', 'max:50'],
            'province' => ['required', 'string'],
            'postal' => ['string', 'max:4'],
            'country' => ['required', 'string', 'max:50'],
            'email' => ['max:50', 'unique:companies'],
            'phone' => ['max:50'],
            'fax' => ['max:50'],
            'tin' => ['max:20'],
            'sss' => ['max:20'],
            'philhealth' => ['max:20'],
            'hdmf' => ['max:20']
        ];
    }
}
