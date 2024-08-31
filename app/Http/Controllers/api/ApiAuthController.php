<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
            'name' => ['required', 'string'],
            'address' => ['required', 'string'],
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $user->assignRole('user');
        
        $token = $user->createToken('token')->plainTextToken;

        return response()->json(['message' => 'Registration successes.', 'token' => $token, 'user' => $user], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:user'],
            'password' => ['required', 'min:8'],
        ]);

        if (Auth::attempt($data, $remember = true)) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken;
            return response()->json(['message' => 'Authenication successes.', 'token' => $token], 200);
        } else {
            return response()->json(['message' => 'Authenication failed.'], 401);
        }
    }
}
