<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Auth;

class AuthService
{

    /**
     * @throws \Exception
     */
    public function login (array $credentials): string|null
    {
        try {

            if(!Auth::attempt($credentials)){
                return null;
            }

            return Auth::user()->createToken('login_token')->plainTextToken;
        }
        catch (\Exception $e) {
           throw $e;
        }
    }

    public function logout(): bool
    {
        Auth::user()->tokens()->delete();
        return true;
    }

}
