<?php

namespace App\Repositories\Assignment;

use App\Models\Assignment;
use App\Repositories\BaseRepository;

class AssignmentRepository extends BaseRepository
{

    public function model()
    {
        return Assignment::class;
    }
}
