<?php

namespace App\Http\Services;

use App\Http\Resources\CourseResource;
use App\Http\Resources\EnrollmentStudentCourseResource;
use App\Models\Enrollment;
use App\Repositories\Assignment\AssignmentRepository;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class CourseService extends BaseService
{
    /**
     * @var repository| \App\Repositories
    */
    protected $courseRepo;
    protected $assignmentRepo;

    public function __construct(
        CourseRepositoryInterface $courseRepo,
        AssignmentRepository $assignmentRepo,
    ) {
        $this->courseRepo = $courseRepo;
        $this->assignmentRepo = $assignmentRepo;
    }
    /**
     * Store a newly created resource in storage.
     * @param $data
     * @return mixed
     */
    public function store($params, $listVideos) {

        $fileName =  uniqid() . '.' . $params['thumbnail']->getClientOriginalName();
        $params['thumbnail']->storeAs('coursesImage', $fileName);
        $params['is_published'] = 0;
        $params['thumbnail'] = $fileName;
        $course = $this->courseRepo->create($params);

        if (!is_null($listVideos)) {
            foreach ($listVideos as $video) {
                $file = $video['file'];
                $videoName = uniqid() . '.' . $file->getClientOriginalName();
                $file->storeAs('videoCourses/', $videoName);

                $dataAssignment = [
                    'course_id' => $course->id,
                    'title' => $video['title'],
                    'description' => $video['description'],
                    'link_video' => $videoName
                ];
                $this->assignmentRepo->create($dataAssignment);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     * @param $data, string id
     * @return mixed
     */
    public function update($params, $listVideos, string $id) {
        $course = $this->courseRepo->findOrFail($id);

        if (!$course) {
            return response()->json($course);
        }
        if (array_key_exists('thumbnail',$params)) {
            $fileName =  uniqid() . '.' . $params['thumbnail']->getClientOriginalName();
            if ($course->thumbnail) {
                Storage::disk('public')->delete('coursesImage/' . basename($course->thumbnail));
            }
            $params['thumbnail']->storeAs('coursesImage', $fileName);
            $params['thumbnail'] = $fileName;
        }

        $this->courseRepo->update($params, $id);

        if (!is_null($listVideos)) {
            foreach ($listVideos as $video) {
                $file = $video['file'];
                $videoName = '';

                if ($file != "0") {
                    $videoName = uniqid() . '.' . $file->getClientOriginalName();
                    $file->storeAs('videoCourses/', $videoName);
                }

                if ($video['link_video']) {
                    if ($videoName != '') {
                        $video['link_video'] = $videoName;
                    } else {
                        unset($video['link_video']);
                    }
                    
                    if (isset($video['deleteOldVideo'])) {
                        $this->assignmentRepo->delete($video['id']);
                    } else {
                        $this->assignmentRepo->update($video, $video['id']);
                    }
                } else {
                    $dataAssignment = [
                        'course_id' => $course->id,
                        'title' => $video['title'],
                        'description' => $video['description'],
                        'link_video' => $videoName
                    ];

                    $this->assignmentRepo->create($dataAssignment);
                }
            }
        }
    }

    /**
     * Get Courses by User Id
     * @param $user , $searchTerm, $limit
     * @return mixed
     */
    public function getUserCourses($user, $searchTerm, $limit) {
        if ($user->role === 'pt') {
            $params = [
                'conditions' => [
                    ['user_id', '=', $user->id],
                    ['title', 'like', "%" . $searchTerm . "%"]
                ],
                'limit' => $limit,
                'sort_by' => 'id',
            ];
            $courses = $this->courseRepo->searchByParams($params);
            return CourseResource::collection($courses);
        }

        if ($user->role === 'student') {
            $enrollments = Enrollment::where('student_id', $user->id)
                ->whereHas('course', function ($query) use ($searchTerm) {
                    $query->where('title', 'like', "%$searchTerm%");
                })
                ->orderByDesc('id')
                ->paginate($limit)
                ->onEachSide(6);

            return EnrollmentStudentCourseResource::collection($enrollments);
        }
    }

    /**
     * Get Course by Trainer Id
     * @param int $id
     * @return mixed
     */
    public function getTrainerCourse($id){
        return $this->courseRepo->where('user_id', $id);
    }
}

