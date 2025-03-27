<?php

namespace App\Http\Requests\v1\Account;

use App\Models\Account;
use Illuminate\Validation\Rule;
use App\Http\Requests\v1\ApiFormRequest;

class AccountUpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', Account::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'accountTypeId' => ['required', 'integer'],
            //this is not working
            'name' => ['required', 'string', 'max:50', Rule::unique('accounts')->ignore($this->id, 'id')],
        ];
    }
}
