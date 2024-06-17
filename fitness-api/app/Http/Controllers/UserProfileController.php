<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Exception;

class UserProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show user profile.
     * @param int $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->userService->show($id);

        if (!$user) {
            return response()->json(['error' => 'User profile not found'], 404);
        }

        return new UserResource($user);
    }

    /**
     * Update user profile.
     * @param int $id
     * @return mixed
     */
    public function update(UserProfileRequest $request, $id)
    {
        try {
            $user = $this->userService->show($id);

            if (!$user) {
                return response()->json(['error' => 'User profile not found'], 404);
            }

            $params = $request->only(['name', 'email', 'user_description', 'user_birthday', 'user_sex', 'user_picture']);
            $profileData = $request->input('profile', []);
            $user = $this->userService->updateProfile($user, $params, $profileData);

            return new UserResource($user);

        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Change pass word.
     * @param int $id
     * @return mixed
     */
    public function updatePassword(PasswordRequest $request, $id)
    {
        try {
            $user = $this->userService->show($id);

            if (!$user) {
                return response()->json(['error' => 'User profile not found'], 404);
            }

            $user = $this->userService->updatePassword($user, $request->password);

            return new UserResource($user);

        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }
}

