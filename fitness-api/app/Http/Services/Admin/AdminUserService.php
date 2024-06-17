<?php

namespace App\Http\Services\Admin;

use App\Http\Resources\UserResource;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Enrollment\EnrollmentRepository;
use App\Repositories\User\IUserProfile;
class AdminUserService
{
    protected $userRepository;
    protected $enrollmentRepository;
    protected $courseRepo;

    public function __construct
    (
        IUserProfile $userRepository,
        EnrollmentRepository $enrollmentRepository,
        CourseRepositoryInterface $courseRepo
    ) {
        $this->userRepository = $userRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->courseRepo = $courseRepo;
    }


    /**
     * Get student and trainer
     * @return mixed
     */
    public function index($searchValue = null, $limit = 5)
    {
        $students = $this->userRepository
            ->where('role', 'student')
            ->when($searchValue !== null && $searchValue !== '', function ($query) use ($searchValue) {
                $query->where(function($subquery) use ($searchValue) {
                    $subquery->where('name', 'like', "%$searchValue%")
                            ->orWhere('email', 'like', "%$searchValue%");
                });
            })
            ->paginate($limit);

        $trainers = $this->userRepository
            ->where('role', 'pt')
            ->when($searchValue !== null && $searchValue !== '', function ($query) use ($searchValue) {
                $query->where(function($subquery) use ($searchValue) {
                    $subquery->where('name', 'like', "%$searchValue%")
                            ->orWhere('email', 'like', "%$searchValue%");
                });
            })
            ->paginate($limit);

        $formattedStudents = [
            'data' => UserResource::collection($students),
            'pagination' => $students->toArray(),
        ];

        $formattedTrainers = [
            'data' => UserResource::collection($trainers),
            'pagination' => $trainers->toArray(),
        ];

        return [
            'trainer' => $formattedTrainers,
            'student' => $formattedStudents,
        ];
    }

    /**
     * Show Detail Resource of student and trainer
     * @param int $id
     * @return mixed
     */
    public function show($searchValue = null, $limit = 5, int $id)
    {
        $trainers = $this->userRepository->findOrFail($id);
        $courses = $this->courseRepo
            ->where('user_id', $id)
            ->when($searchValue !== null && $searchValue !== '', function ($query) use ($searchValue) {
                $query->where(function($subquery) use ($searchValue) {
                    $subquery->where('title', 'like', "%$searchValue%")
                        ->orWhere('description', 'like', "%$searchValue%");
                });
            })
            ->paginate($limit);;

        return [
            'trainer' => new UserResource($trainers),
            'courses' => $courses,
        ];
    }

    /**
     * Get All student of Course
     * @param int id
     * @return mixed
     */
    public function getStudentList($searchValue = null, $limit = 5, $id)
    {
        $enrollments = $this->enrollmentRepository
            ->where('course_id', $id)
            ->join('users', 'enrollments.student_id', '=', 'users.id')
            ->when($searchValue !== null && $searchValue !== '', function ($query) use ($searchValue) {
                $query->where(function($subquery) use ($searchValue) {
                    $subquery->where('name', 'like', "%$searchValue%")
                            ->orWhere('email', 'like', "%$searchValue%");
                });
            })
            ->paginate($limit);

        return $enrollments;
    }

    /**
     * Get Infor about Student
     * @param int id
     * @return mixed
     */
    public function getStudentDetail($searchValue = null, $limit = 5, $id)
    {
        $students = $this->userRepository->findOrFail($id);
        $courses = $this->enrollmentRepository
            ->where('enrollments.student_id', $id)
            ->join('courses', 'courses.user_id', '=', 'enrollments.course_id')
            ->when($searchValue !== null && $searchValue !== '', function ($query) use ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('courses.title', 'like', "%$searchValue%")
                        ->orWhere('courses.description', 'like', "%$searchValue%");
                });
            })
            ->paginate($limit);

        return [
            'student' => new UserResource($students),
            'courses' => $courses,
        ];
    }
}

