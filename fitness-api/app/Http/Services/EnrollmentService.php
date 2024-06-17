<?php

namespace App\Http\Services;

use App\Http\Resources\AssignmentResource;
use App\Repositories\Assignment\AssignmentRepository;
use App\Repositories\Enrollment\EnrollmentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class EnrollmentService extends BaseService
{
    protected $enrollmentRepository;
    protected $userRepository;
    protected $assignmentRepository;

    public function __construct(
        EnrollmentRepository $enrollmentRepository,
        UserRepository $userRepository,
        AssignmentRepository $assignmentRepository
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->userRepository = $userRepository;
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * Create new Enrollment
     * @param array $request
     * @return mixed
     */
    public function store($data)
    {
        $enrollment = $this->enrollmentRepository->create($data);

        return $enrollment;
    }

    /**
     * Get Assignment by enrollment
     * @param mixed $enrollment
     * @param mixed $searchValue
     * @return mixed
     */
    public function getAssignments($enrollment, $searchValue, $limit = 5)
    {
        $course = $enrollment->course;

        $assignments = $this->assignmentRepository
            ->where('course_id', $course->id)
            ->when($searchValue !== null && $searchValue !== '', function($query) use($searchValue){
                $query->where(function($subquery) use ($searchValue) {
                    $subquery->where('title', 'like', "%$searchValue%")
                        ->orWhere('description', 'like', "%$searchValue%");
                });
            })
            ->orderByDesc('id')
            ->paginate($limit);

        return AssignmentResource::collection($assignments);
    }
}
