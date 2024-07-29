<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $data = $request->validationData();
        $user = User::create($data);

        $token = $user->createToken('user_token')->plainTextToken;

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }

    public function login(AuthLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->post('email'))->first();
        if (! $user ) {
            return response()->json(['status' => 'error', 'message' => 'email not found'], 404);
        }

        if (! Hash::check($request->post('password'), $user->password) ) {
            return response()->json(['status' => 'error', 'message' => 'wrong password'], 400);
        }

        $token = $user->createToken($request->post('email'))->plainTextToken;

        return response()->json([
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    public function user(): JsonResponse
    {
        return response()->json([
            'data' => [
                'user' => Auth::user()
            ]
        ]);
    }
}
