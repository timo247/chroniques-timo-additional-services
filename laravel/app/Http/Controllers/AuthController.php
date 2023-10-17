<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->sendResponse(['access_token' => $token, 'user' => $user->toArray()], 'User register successfully.');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request['email'])->firstOrFail();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token, 'user' => $user, "message" => "user logged in successfully"
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "user logged out successfully", 'user' => $request->user()
        ]);
    }

    public function getAccount(Request $request)
    {
        return response()->json([
            'user retrieved' => $request->user()
        ]);
    }
}