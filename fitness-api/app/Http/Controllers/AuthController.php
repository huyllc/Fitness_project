<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Services\AuthService;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct( AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'register']]);
    }

    /**
     * Handler User Login
     * @param Request $request
     * @return mixed
     */
    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $checkLogin = $this->authService->login($credentials);
        if (is_array($checkLogin)) {
            return $checkLogin;
        };
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $refrehToken = $this->createRefreshToken();

        return $this->respondWithToken($token, $refrehToken);
        
    }
    
    /**
     * Handler User Logout
     * @return mixed
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $refreh_token =  request()->refresh_token;
        try {
            $decoded = JWTAuth::getJWTProvider()->decode($refreh_token);
            $user = User::find($decoded['user_id']);

            if ($user) {
                auth('api')->invalidate();

                $token = auth('api')->login($user);
                $refrehToken = $this->createRefreshToken();

                return $this->respondWithToken($token, $refrehToken);
            }
        } catch (JWTException $exception) {
            return response()->json([
                'error' => true,
                'message' => 'Refresh token not valid'
            ]);
        }
    }

    /**
     * Handler User Register
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'email|required|string|unique:users,email',
            'password' => 'required|string',
            'name' => 'string',
            'role' => 'in:student,pt'
        ]);

        try {
            $user = $this->authService->register($credentials);

            if ($user) {
            $token = auth('api')->login($user);
                $refrehToken = $this->createRefreshToken();

                return $this->respondWithToken($token, $refrehToken);
            }

        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ], 200);
        }
    }

    /**
     * Get the token array structure.
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $refrehToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refrehToken,
            'token_type' => 'bearer',
            'user_type' => auth('api')->user()->role,
            'c_user' => auth('api')->user()->id,
            'expires_in' => auth('api')->factory()->getTTL() * 3600
        ]);
    }

    /**
     * Create data refresh token
     * @return mixed
     */
    private function createRefreshToken()
    {
        $data = [
            'user_id' => auth('api')->user()->id,
            'random' => rand().time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];
        $refrehToken = JWTAuth::getJWTProvider()->encode($data);

        return $refrehToken;
    }
}
