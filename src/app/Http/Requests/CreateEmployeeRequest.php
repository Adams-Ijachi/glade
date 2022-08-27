<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:11|unique:employees,phone',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
