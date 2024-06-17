<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\ReviewService;
use Exception;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Get List Resource
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $searchValue = $request->search;

        return $this->reviewService->getList($searchValue);
    }

        /**
     * Get List Resource
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        try {
            $this->reviewService->update($request->all(), $request->id);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Update Successfully'
        ]);
    }
}
