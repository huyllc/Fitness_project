<?php

namespace App\Repositories\Enrollment;

use App\Models\Enrollment;
use App\Repositories\BaseRepository;

class EnrollmentRepository extends BaseRepository
{
    /**
     * Set Model for Class
     */
    public function model()
    {
        return Enrollment::class;
    }
}
