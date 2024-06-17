<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Services\ContactService;
use Exception;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Send Message To Email
     *
     * /**
    * @OA\Post(
    *      path="/api/send-contact",
    *      summary="Contact-us data",
    *      description="",
    *      tags={"Contact"},
    *      @OA\RequestBody(
    *               required = true,
    *               @OA\JsonContent(ref="#/components/schemas/ContactRequest")
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="Operation successful",
    *          @OA\MediaType(
    *              mediaType="application/json"
    *          )
    *      )
    * )
    */
    public function send(ContactRequest $request)
    {
        try {
            $contactData = $request->only(['name', 'email', 'phone', 'message']);
            $this->contactService->sendMessage($contactData);

            return response()->json(['message' => 'Email sent successfully'], 200);

        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }
}

