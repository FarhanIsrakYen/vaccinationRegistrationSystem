<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class VaccinationRegistrationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','max:255'],
            'email' => ['required','max:255', 'unique:users,email','email:filter'],
            'phone' => ['required','unique:users,phone'],
            'nid' => ['required','unique:users,nid'],
            'vaccine_center_id' => ['required','exists:vaccine_centers,id']
        ];
    }

    public function failedValidation(Validator $validator) : Response {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->getMessageBag()
        ], Response::HTTP_BAD_REQUEST));
    }
}
