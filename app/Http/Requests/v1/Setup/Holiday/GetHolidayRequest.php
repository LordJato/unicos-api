<?php

namespace App\Http\Requests\v1\Setup\Holiday;

use App\Models\Setup\Holiday;
use App\Http\Requests\v1\ApiFormRequest;

class GetHolidayRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('view', Holiday::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }
}
