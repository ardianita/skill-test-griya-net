<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRequest $userRequest, ResponseFormatter $responseFormatter)
    {
        $validator = $userRequest->validated();
        $validator['password'] = bcrypt($validator['password']);

        $user = User::create($validator);

        try {
            return $responseFormatter->success($user, 'Register Successfully!', 201);
        } catch (\Throwable $th) {
            return $responseFormatter->error($th, 'Failed Registered!', 400);
        }
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged Out!'
        ], 202);
    }
}
