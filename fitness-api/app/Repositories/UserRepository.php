<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    /**
     * Set Model for Class
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Get User By Email
     * @param string $email
     * @return mixed|User
     */
    public function getByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
