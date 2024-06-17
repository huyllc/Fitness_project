<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


/**
 * @OA\Schema(
 *      properties = {
 *          @OA\Property(property="name", type="string"),
 *          @OA\Property(property="email", type="string", format="email"),
 *          @OA\Property(property="message", type="string"),
 *          @OA\Property(property="phone", type="string"),
 *      }
 * )
 */
class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'email' => 'required|email',
            'message' => 'required',
            'phone' => ['required', 'regex:/^\+?\d{8,}$/']
        ];
    }

    /**
     * return message if input error
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
