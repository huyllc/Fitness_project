<?php

namespace App\Http\Controllers;

use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use App\Repositories\Assignment\AssignmentRepository;
use Exception;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    protected $assignmentRepository;

    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * Get Assignment for Course Student
     * @param Request $request
     * @param int $courseId
     * @return mixed
     */
    public function get(Request $request, $courseId)
    {
        $searchValue = $request->search;

        try {
            $result = $this->assignmentRepository->where('course_id', $courseId)
            ->when($searchValue !== null && $searchValue !== '', function($query) use($searchValue){
                $query->where(function($subquery) use ($searchValue) {
                    $subquery->where('title', 'like', "%$searchValue%")
                            ->orWhere('description', 'like', "%$searchValue%");
                });
            })
            ->orderByDesc('id')
            ->paginate(5);

            return AssignmentResource::collection($result);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }
}

