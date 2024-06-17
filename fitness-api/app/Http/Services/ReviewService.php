<?php

namespace App\Http\Services;

use App\Http\Resources\Admin\ReviewResource as AdminReviewResource;
use App\Http\Resources\ReviewResource;
use App\Repositories\ReviewRepository;

class ReviewService extends BaseService
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Store new review to recourse
     * @param array $data
     * @return mixed
     */
    public function store($data)
    {
        return $this->reviewRepository->create($data);
    }

    /**
     * Update review to recourse
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function update($data, $id)
    {
        return $this->reviewRepository->update($data, $id);
    }

    /**
     * Get List Resource
     * @param string $searchValue
     * @return mixed
     */
    public function getList($searchValue = '')
    {
        $reviews = $this->reviewRepository
            ->select(
                'course_reviews.id',
                'users.name',
                'courses.title',
                'course_reviews.content',
                'course_reviews.rate',
                'course_reviews.is_published'
            )
            ->join('users', 'course_reviews.user_id', '=', 'users.id')
            ->join('courses', 'course_reviews.course_id', '=', 'courses.id')
            ->when($searchValue !== null && $searchValue !== '', function ($query) use ($searchValue) {
                $query->where(function($subquery) use ($searchValue) {
                    $subquery->where('content', 'like', "%$searchValue%")
                        ->orWhere('name', 'like', "%$searchValue%")
                        ->orWhere('title', 'like', "%$searchValue%");
                });
            })
            ->paginate(5);

        return AdminReviewResource::collection($reviews);
    }

    /**
     * Get List Review By CourseId
     * @param int $courseId
     */
    public function getByCourse($courseId)
    {
        $reviews = $this->reviewRepository
            ->where('course_id', $courseId)
            ->where('is_published', 1)
            ->paginate(3);

        return ReviewResource::collection($reviews);
    }
}
