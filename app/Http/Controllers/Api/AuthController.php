<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        // Add User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return Response
        return ApiResponseService::success(
            [
                'user' => UserResource::make($user),
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ],
            'Register successful',
            201
        );
    }

    // Login Controller
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return ApiResponseService::error('Unauthorized', 401);
        }

        // token & login
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return Response
        return ApiResponseService::success([
            'user' => UserResource::make($user),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ], 'Login successful',200);
    }
}
