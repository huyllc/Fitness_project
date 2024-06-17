<?php

namespace App\Http\Services\Admin;

use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepository;

class AdminCourseService
{
    protected $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Get List of Resource
     * @return mixed
     */
    public function index($searchValue = null, $limit = 5)
    {
        $courses = $this->courseRepository
            ->when($searchValue !== null && $searchValue !== '', function ($query) use ($searchValue) {
                $query->where('title', 'like', "%$searchValue%");
            })
            ->paginate($limit);;

        return $courses;
    }

    /**
     * Show Detail Resource
     * @param int $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->courseRepository->findOrFail($id);
    }

    /**
     * Update status Course
     * @param int $id
     * @return mixed
     */
    public function update($id, $status)
    {
        $course = $this->courseRepository->find($id);
        $course->update(['is_published' => $status]);

        return $course;
    }
}

