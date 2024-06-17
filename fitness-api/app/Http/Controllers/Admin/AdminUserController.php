<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnrollmentStudentResource;
use App\Http\Services\Admin\AdminUserService;
use Exception;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    protected $adminUserService;

    public function __construct(AdminUserService $adminUserService) {
        $this->adminUserService = $adminUserService;
    }

    /**
     * Get student and trainer
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $searchValue = $request->search;
            $limit = $request->limit ?? 5;

            return $this->adminUserService->index($searchValue, $limit);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Show Detail Resource of student and trainer
     * @param int $id
     * @return mixed
     */
    public function show(Request $request, int $id)
    {
        try{
            $searchValue = $request->search;
            $limit = $request->limit ?? 5;

            return $this->adminUserService->show($searchValue, $limit, $id);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Get All student of Course
     * @param int id
     * @return mixed
     */
    public function getStudentList(Request $request, $id)
    {
        try {
            $searchValue = $request->search;
            $limit = $request->limit ?? 5;
            $enrollments = $this->adminUserService->getStudentList($searchValue, $limit, $id);

            return EnrollmentStudentResource::collection($enrollments);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Get Infor about Student
     * @param int id
     * @return mixed
     */
    public function getStudentDetail(Request $request, $id)
    {
        try {
            $searchValue = $request->search;
            $limit = $request->limit ?? 5;

            return $this->adminUserService->getStudentDetail($searchValue, $limit, $id);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }
}



