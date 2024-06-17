<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest\StoreCourseRequest;
use App\Http\Requests\CourseRequest\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseReviewResource;
use App\Http\Services\CourseService;
use App\Repositories\Course\CourseRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class CourseController extends Controller
{
     /**
     * @var Services| \App\Http\Services
     */
    protected $courseService;


    /**
     * @var Repository| \App\Repositories
     */
    protected $courseRepo;


    public function __construct(
        CourseRepositoryInterface $courseRepo,
        CourseService $courseService
    ) {
        $this->courseService = $courseService;
        $this->courseRepo = $courseRepo;
    }

    /**
     * Display a listing of the resource.
     * @return mixed
     */
    public function index()
    {
        try {
            $courses = $this->courseRepo->get();

            return response()->json($courses);
        } catch(Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     * @return mixed
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            $params = $request->only(['user_id', 'title', 'description', 'duration', 'thumbnail']);
            $listVideos = $request->listVideos;
            $this->courseService->store($params, $listVideos);

            return response()->json([
                'error' => false,
                'message' => "success"
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return mixed
     */
    public function show(string $id)
    {
        try {
            $course = $this->courseRepo->findOrFail($id);
            return new CourseResource($course);
        } catch(Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     * @param Request request , string id
     * @return mixed
     */
    public function update(UpdateCourseRequest $request, string $id)
    {
        try {
            $params = $request->only(['title', 'description', 'duration', 'thumbnail']);
            if (!$request->hasFile('thumbnail')) {
                unset($params['thumbnail']);
            }
            $listVideos = $request->listVideos;
            $this->courseService->update($params, $listVideos, $id);
        } catch (Exception) {
            return response()->json([
                'error' => true,
                'message' => 'Failed'
            ]);
        }
        return response()->json([
            'error' => false,
            'message' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return mixed
     */
    public function destroy(string $id)
    {
        try{
            $course = $this->courseRepo->delete($id);
            if ($course) {
                return response()->json(['message' => 'Delete Success']);
            }
        } catch(Exception) {
            return response()->json([
                'error' => true,
                'message' => 'Failed'
            ]);
        }


    }

    /**
     * Get List Course Review Data
     * @param Request $request
     * @return mixed
     */
    public function getListCourseReviews(Request $request)
    {
        try {
            $courses = $this->courseRepo->where('is_published', 1)->orderBy('id')->paginate($request->limit);
            return CourseReviewResource::collection($courses);
        } catch(Exception) {
            return response()->json([
                'error' => true,
                'message' => 'Failed'
            ]);
        }
    }

    /**
     * Get List Course Popular
     * @param Request $request
     * @return mixed
     */
    public function getCoursePopular()
    {
        try {
            $courses = $this->courseRepo->where('is_published', 1)->orderByDesc('id')->limit(3)->get();
            return CourseReviewResource::collection($courses);
        } catch(Exception) {
            return response()->json([
                'error' => true,
                'message' => 'Failed'
            ]);
        }

    }

    /**
     * Get Courses by User Id
     * @param Request $request
     * @return mixed
     */
    public function getUserCourses(Request $request)
    {
        try {
            $user = auth()->user();
            $searchTerm = $request->get('search');
            $limit = 5;
            if (isset($request->limit)) {
                $limit = $request->limit;
            }
            return $this->courseService->getUserCourses($user, $searchTerm, $limit);
        } catch(Exception) {
            return response()->json([
                'error' => true,
                'message' => 'Failed'
            ]);
        }
    }

    /**
     * Get Course by Trainer Id
     * @param int $id
     * @return mixed
     */
    public function getTrainerCourse(Request $request, $id){
        try {
            $limit = 5;

            if (isset($request->limit)) {
                $limit = $request->limit;
            }

            $courses = $this->courseService->getTrainerCourse($id)->paginate($limit);

            return CourseReviewResource::collection($courses);
        } catch(Exception) {
            return response()->json([
                'error' => true,
                'message' => 'Failed'
            ]);
        }

    }
}

