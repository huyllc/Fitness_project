<?php

namespace App\Http\Services;

use App\Repositories\Submission\SubmissionRepository;
use Exception;
use Illuminate\Http\Request;

class SubmissionService extends BaseService
{
    protected $submissionRepository;

    public function __construct(SubmissionRepository $submissionRepository)
    {
        $this->submissionRepository = $submissionRepository;
    }

    /**
     * Add Submission
     * @param array $request
     * @return mixed
     */
    public function store($data)
    {
        $submission = $this->submissionRepository->create($data);

        if ($submission) {
            return true;
        }

        return false;
    }
}
