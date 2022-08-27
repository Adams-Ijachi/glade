<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:255|unique:employees,phone,' . $this->route('employee')->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('employee')->user->id,
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
