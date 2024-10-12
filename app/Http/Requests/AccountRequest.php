<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

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
                if (Route::currentRouteName() === 'accounts.index') {
                    return Gate::allows('view-all-account');
                } else {
                    return Gate::allows('view-account');
                }
            }

            if ($this->isMethod('post')) {
                return Gate::allows('create-account');
            }

            if ($this->isMethod('put')) {
                return Gate::allows('update-account');
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
