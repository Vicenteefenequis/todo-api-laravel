<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Exception;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json($user);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }


    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }


        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;


        return response([
            'token' => $token
        ]);
    }


    public function profile()
    {
        $user = Auth::user();

        if (!$user) return response()->json([
            'error' => 'Unauthenticated.'
        ]);

        return response()->json($user);
    }


    public function logout()
    {
        $user = Auth::user();

        if (!$user) return response()->json([
            'error' => 'Unauthenticated.'
        ]);

        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'user is logout']);
    }
}
