<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseReviewResource;
use App\Models\Course;
use App\Repositories\Course\CourseRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @var CourseRepositoryInterface
     */
    protected $userRepo;

    /**
     * @var CourseRepositoryInterface
     */
    protected $courseRepo;

    public function __construct(UserRepository $userRepository, CourseRepository $courseRepository)
    {
        $this->userRepo = $userRepository;
        $this->courseRepo = $courseRepository;
    }

    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function search(Request $request)
    {
        $searchTerm = $request->get('search');
        $results = Course::where([
                ['courses.title', 'like', "%$searchTerm%"],
                ['courses.is_published' , '=' , 1],
            ])
            ->orWhereHas('user', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%$searchTerm%");
            }) -> orderBy('id', 'asc')-> limit($request->limit)->paginate($request->limit, "*");

        return CourseReviewResource::collection($results);
    }
}

