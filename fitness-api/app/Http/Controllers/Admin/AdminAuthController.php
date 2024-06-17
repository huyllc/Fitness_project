<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Handle Admin Login
     * @param AuthRequest $request
     * @return mixed
     */
    public function login(AuthRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('admin')->attempt($credentials)) {
            $token = Auth::guard('admin')->user()->createToken('adminToken')->plainTextToken;
            return response()->json([
                'token' => $token,
            ], 200)->cookie(
                'adminToken',
                $token,
                60 * 24 * 7,
                null,
                null,
                false,
                true
            );
        }
        return response()->json([
            'message' => 'Tài khoản hoặc mật khẩu không chính xác'
        ], 401);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'error' => false,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Verify Token
     * @param Request $request
     * @return mixed
     */
    public function verifyToken(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => true,
                'message' => 'Token not valid'
            ]);
        }
    }
}

