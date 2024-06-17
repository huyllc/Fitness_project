<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Course\CourseRepository;
use App\Repositories\UserRepository;

class AdminController extends Controller
{
    protected $userRepository;
    protected $courseRepository;

    public function __construct(UserRepository $userRepository, CourseRepository $courseRepository)
    {
        $this->userRepository = $userRepository;
        $this->courseRepository = $courseRepository;
    }

    /**
     * Get total pt, total student, course
     * @return mixed
     */
    public function index()
    {
        return response()->json([
            'total_trainer' => $this->userRepository->where('role', 'pt')->count(),
            'total_student' => $this->userRepository->where('role', 'student')->count(),
            'total_course' => $this->courseRepository->count()
        ]);
    }
}

