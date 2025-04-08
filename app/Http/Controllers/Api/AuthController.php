<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ApiResponseService;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

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
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ],
            'Register successful', 201
        );
    }
}
