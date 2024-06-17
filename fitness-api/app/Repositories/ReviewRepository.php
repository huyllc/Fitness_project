<?php

namespace App\Repositories;

use App\Models\CourseReview;

class ReviewRepository extends BaseRepository
{
    /**
     * Set Model for Class
     */
    public function model()
    {
        return CourseReview::class;
    }
}
