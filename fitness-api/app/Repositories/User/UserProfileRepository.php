<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Repositories\User\IUserProfile;
use App\Models\User;

class UserProfileRepository extends BaseRepository implements IUserProfile
{
    /**
     * Set Model for Class
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

}
