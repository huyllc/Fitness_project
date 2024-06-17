<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Services\Admin\AdminCourseService;
use Exception;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    protected $adminCourseService;

    public function __construct(AdminCourseService $adminCourseService)
    {
        $this->adminCourseService = $adminCourseService;
    }

    /**
     * Get List of Resource
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $searchValue = $request->search;
            $limit = $request->limit ?? 5;

            return $this->adminCourseService->index($searchValue, $limit, $request);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Show Detail Resource
     * @param int $id
     * @return mixed
     */
    public function show($id)
    {
        try {
            return new CourseResource($this->adminCourseService->show($id));
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Update status Course
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        try {
            $status = $request->status;
            $result = $this->adminCourseService->update($id, $status);

            if ($result) {
                return response()->json([
                    'error' => false,
                    'message' => 'Update successful'
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Update failed'
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
