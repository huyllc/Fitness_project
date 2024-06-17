<?php

namespace App\Http\Controllers;

use App\Http\Services\ReviewService;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Store new review to recourse
     * @param Request $rquest
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $dataValidate = $request->validate([
                'rate' => 'required|integer',
                'content' => 'required|string',
                'course_id' => 'required|integer'
            ]);

            $data = array_merge($dataValidate, [
                'user_id' => $request->user()->id,
            ]);

            $this->reviewService->store($data);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Your review has been sent to admin. Please wait for a response!'
        ]);
    }

    /**
     * Get List Review By CourseId
     * @param int $id
     * @return mixed
     */
    public function getByCourse($id)
    {
        return $this->reviewService->getByCourse($id);
    }
}
