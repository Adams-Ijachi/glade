<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:companies,name',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'logo' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'website' => 'url',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
