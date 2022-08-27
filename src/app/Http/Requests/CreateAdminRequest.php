<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class CreateAdminRequest extends FormRequest
{
    #[ArrayShape(['email' => "string", 'password' => "string", 'first_name' => "string", 'last_name' => "string"])]
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
