<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller {
    public function login(Request $request) {
        $credentials = $request->only('username', 'password');
      
        if (Auth::attempt($credentials)) {

            $user = auth()->user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'token' => $token,
                    'admin' => [
                        'id' => $user->user_id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'phone' => $user->phone,
                        'email' => $user->email,
                    ]
                ]
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials',
        ], 401);
    }


    public function logout(Request $request) {
      
       

       
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful',
        ]);
    }
}