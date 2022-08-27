<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('admin')->id,
            'password' => 'string|min:6',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
        ];
    }

    public function authorize(): bool
    {


        return true;
    }
}
