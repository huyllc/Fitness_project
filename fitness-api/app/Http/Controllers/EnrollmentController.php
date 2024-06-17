<?php

namespace App\Http\Controllers;

use App\Http\Resources\EnrollmentStudentResource;
use App\Http\Services\EnrollmentService;
use App\Mail\NotificationMail;
use App\Notifications\NewRegister;
use App\Repositories\Enrollment\EnrollmentRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnrollmentController extends Controller
{
    const REGISTERED = 1;
    const NOREGISTERED = 0;
    protected $enrollmentRepository;
    protected $enrollmentService;
    public function __construct(
        EnrollmentRepository $enrollmentRepository,
        EnrollmentService $enrollmentService
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * Create new Enrollment
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $dataValidate = $request->validate([
                'student_id' => 'required|integer',
                'course_id' => 'required|integer'
            ]);
            $data = array_merge($request->all(), $dataValidate);
            $enrollmentInstance = $this->enrollmentService->store($data);
            Mail::to($enrollmentInstance->user->email)->send(new NotificationMail($enrollmentInstance));
            $enrollmentInstance->course->user->notify(new NewRegister($enrollmentInstance->user, $enrollmentInstance->course));
            if ($enrollmentInstance) {
                return response()->json([
                    'error' => false,
                    'message' => 'Register course success',
                ]);
            }
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Check user is Registered
     * @param Request $request
     * @return mixed
     */
    public function checkUserIsRegistered(Request $request)
    {
        try {
            $enrollment = $this->enrollmentRepository
                ->where('course_id', $request->courseId)
                ->where('student_id', $request->userId)
                ->first();
            if (!$enrollment) {
                return response()->json([
                    'status' => self::NOREGISTERED
                ]);
            }
            return response()->json([
                'status' => self::REGISTERED
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => self::NOREGISTERED,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Get All student of Course
     * @param string $id
     * @return mixed
     */
    public function getStudentCourse(Request $request, $id) {
        $limit = 5;
        $searchValue = $request->search;

        if (isset($request->limit)) {
            $limit = $request->limit;
        }

        try {
            $enrollments = $this->enrollmentRepository
                ->where('course_id', $id)
                ->join('users', 'enrollments.student_id', '=', 'users.id')
                ->when($searchValue !== null && $searchValue !== '', function($query) use($searchValue){
                    $query->where(function($subquery) use ($searchValue) {
                        $subquery->where('name', 'like', "%$searchValue%")
                            ->orWhere('email', 'like', "%$searchValue%");
                    });
                })
                ->paginate($limit);

            return EnrollmentStudentResource::collection($enrollments);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Get Enrollment with courseId and Student Id
     * @param Request $request
     * @param int $studentId
     * @param int $courseId
     * @return mixed
     */
    public function getEnrollment(Request $request, $studentId, $courseId)
    {
        $searchValue = $request->search;

        try {
            $enrollmentInstance = $this->enrollmentRepository
                ->where('course_id', $courseId)
                ->where('student_id', $studentId)
                ->first();

            $result = $this->enrollmentService->getAssignments($enrollmentInstance, $searchValue);

            return $result;
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }
}

