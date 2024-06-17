<?php

namespace App\Http\Services;

use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\User\IUserProfile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userProfile;
    protected $courseRepo;

    public function __construct(IUserProfile $userProfile, CourseRepositoryInterface $courseRepo)
    {
        $this->userProfile = $userProfile;
        $this->courseRepo = $courseRepo;
    }

    /**
     * Show user profile.
     * @param int $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->userProfile->findOrFail($id);
    }

    /**
     * Update user profile.
     * @param int $id
     * @return mixed
     */
    public function updateProfile($user, $params, $profileData)
    {
        $user->update($params);

        unset($profileData['created_at']);
        unset($profileData['updated_at']);

        if (array_key_exists('user_sex', $params)) {
            $profileData['sex'] = $params['user_sex'];
        }

        if (array_key_exists('user_birthday', $params)) {
            $profileData['birthday'] = $params['user_birthday'];
        }

        if (array_key_exists('user_description', $params)) {
            $profileData['description'] = $params['user_description'];
        }

        if (array_key_exists('user_picture', $params) && $params['user_picture'] instanceof \Illuminate\Http\UploadedFile) {
            $profileData['picture'] = $params['user_picture'];
            $fileName =  uniqid() . '.' . $profileData['picture']->getClientOriginalName();
            if ($user->profile->picture && basename($user->profile->picture) !== "DefaultAvatar.png") {
                Storage::disk('public')->delete('profileImage/' . basename($user->profile->picture));
            }
            $profileData['picture']->storeAs('profileImage', $fileName);
            $profileData['picture'] = $fileName;
        }

        $user->profile()->update($profileData);

        return $user;
    }

    /**
     * Change pass word.
     * @param int $id
     * @return mixed
     */
    public function updatePassword($user, $newPassword)
    {
        if ($newPassword) {
            $user->password = Hash::make($newPassword);
            $user->save();
        }

        return $user;
    }
}
