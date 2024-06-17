<?php

namespace App\Http\Controllers;

use App\Http\Services\SubmissionService;
use App\Repositories\Submission\SubmissionRepository;
use Exception;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    protected $submissionRepository;
    protected $submissionService;

    public function __construct(SubmissionRepository $submissionRepository, SubmissionService $submissionService)
    {
        $this->submissionRepository = $submissionRepository;
        $this->submissionService = $submissionService;
    }

    /**
     * Add Submission
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:mp4'
            ]);

            if ($request->has('file')) {
                $videoName = uniqid() . '.' . $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->storeAs('video/submission/'.date('Y/m/d'), $videoName);
                $dataSubmission = array_merge($request->all(), [
                    'link_video' => $path
                ]);

                $result = $this->submissionService->store($dataSubmission);

                if ($result) {
                    return response()->json([
                        'error' => false
                    ]);
                }
            }
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Update Submisson
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request, string $id) {
        $params = $request->only(['grade', 'feed_back']);
        $this->submissionRepository->update($params, $id);
        return response() -> json(["message" => 'success']);
    }
}

