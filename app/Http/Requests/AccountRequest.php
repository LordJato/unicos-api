<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        if ($user !== null && $user instanceof User) {
            if ($this->isMethod('get')) {
                return $user->hasPermissionTo(['view-account']);
            }

            if ($this->isMethod('post')) {
                return $user->hasPermissionTo(['create-account']);
            }

            if ($this->isMethod('put')) {
                return $user->hasPermissionTo(['update-account']);
            }
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('get')) {
            return [
                'id' => 'required',
            ];
        }

        if ($this->isMethod('post')) {
            return [
                'name' => 'required|string|max:150|unique:accounts',
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'name' => 'required|string|max:150|unique:accounts,name,' . request()->id,
                'is_active' => 'boolean'
            ];
        }
    }
}
