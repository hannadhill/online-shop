<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "data" => [
                    "errors" => $validator->errors()->all()
                ]
            ], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json([
            "data" => $response
        ], 201);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return [
            'message' => 'Logged out successfully'
        ];
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required','string', 'email','max:255'],
            'password' => ['required','string','min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "data" => [
                    "message" => "Validation Error",
                    "errors" => $validator->errors()
                ]
            ], 422);
        }

        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                "data" => ["message" => "Unauthorized"]
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('myapptoken')->plainTextToken;

        return response()->json([
            "data" => [
                "user" => $user,
                "token" => $token
            ]
        ]);
    }
}
