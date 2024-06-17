<?php

namespace App\Http\Services;

use App\Models\Profile;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

        /**
     * Handler User Login
     * @param array $credentials
     * @return mixed
     */
    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            Auth::user();
            return true;
        }

        return [
            'errors' => [
                'email' => ['Email or password is not true'],
                'password' => []
            ]
        ];
    }

    /**
     * Handler User Register
     * @param array $credentials
     * @return mixed
     */
    public function register($credentials)
    {
        $user = $this->userRepository->create([
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'name' => $credentials['name'],
            'role' => $credentials['role'],
        ]);

        Profile::create(['user_id' => $user->id, 'picture'=>'DefaultAvatar.png']);

        return $user;
    }
}
