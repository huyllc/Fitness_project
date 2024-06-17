<?php

namespace App\Repositories\Submission;

use App\Models\Submission;
use App\Repositories\BaseRepository;

class SubmissionRepository extends BaseRepository
{
    public function model()
    {
        return Submission::class;
    }
}
