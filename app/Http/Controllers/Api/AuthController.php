<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string|max:255',
            "email" => 'required|string|email|max:255|unique:users',
            "password" => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            $data = [
                'success' => false,
                'message' => 'Validation data error',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }
        try {
            //code...
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
            $data = [
                'success' => true,
                'message' => 'User register successfully',
                'access_token' => $token,
                'post' => $user,
            ];
            return response()->json($data, 201);
        } catch (\Exception $exception) {
            $data = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            return response()->json($data, 403);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => 'required|string|email',
            "password" => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            $data = [
                'success' => false,
                'message' => 'Validation data error',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }
        $credentials = ['email' => $request->email, 'password' => $request->password];
        try {
            if (!auth()->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }
            $user = User::where('email', $request->email)->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;
            $data = [
                'success' => true,
                'message' => 'User login successfully',
                'access_token' => $token,
                'post' => $user,
            ];
            return response()->json($data, 200);
        } catch (\Exception $th) {
            $data = [
                'success' => false,
                'message' => $th->getMessage(),
            ];
            return response()->json($data, 403);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'User logout successfully',
        ], 200);
    }
}
