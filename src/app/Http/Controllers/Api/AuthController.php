<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\AuthService;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use ResponseTrait;
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

    }

    /**
     * @throws \Exception
     */
    public function login(LoginRequest $request)
    {

        try {
            $token = $this->authService->login($request->validated());
            if (!$token) {
                return $this->failed('Invalid Username/Password');
            }
            return UserResource::make(Auth::user())
                                    ->additional(['token' => $token, 'message' => 'Login successful']);

        }catch (\Exception $e) {
            return $this->failed($e->getMessage());
        }

    }

    /**
     * @throws \Exception
     */
    public function logout(Request $request)
    {
        try {
            $this->authService->logout();
            return $this->success('Logout successful');
        }
        catch (\Exception $e) {
            throw $e;
        }

    }
}
