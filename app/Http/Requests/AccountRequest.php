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
        $user = Auth::guard('api')->user();

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

            if ($this->isMethod('delete')) {
                return Gate::allows('delete-account');
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
        if ($this->isMethod('get') && Route::currentRouteName() != 'accounts.') {
            return [
                'id' => 'required',
            ];
        }

        if ($this->isMethod('get')) {
            return [
                'search' => ['nullable', 'min:3', 'max:100'],
                'offset' => ['nullable', 'integer', 'min:0'],
                'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
                'orderBy' => ['nullable', 'string', 'in:id,name'],
                'orderDesc' => ['nullable', 'string'],
            ];
        }

        if ($this->isMethod('post')) {
            return [
                'accountTypeId' => 'required|integer|max:1',
                'name' => 'required|string|max:150|unique:accounts',
            ];
        }

        if ($this->isMethod('put')) {
            return [
                'id' => 'required',
                'name' => 'required|string|max:150|unique:accounts,name,' . request()->id,
            ];
        }

        if ($this->isMethod('delete')) {
            return [
                'id' => 'required'
            ];
        }

        return [];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->isMethod('get')) {
            $this->merge([
                'search' => $this->input('search', null),
                'offset' => (int) $this->input('offset', 0),
                'limit' => (int) $this->input('limit', 10),
                'orderBy' => $this->input('orderBy', 'id'),
                'orderDesc' => $this->input('orderDesc') === 'true' ? 'desc' : 'asc',
            ]);
        }
    }
}
