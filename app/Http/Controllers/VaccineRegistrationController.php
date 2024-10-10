<?php

namespace App\Http\Controllers;

use App\Http\Requests\VaccinationRegistrationRequest;
use App\Services\VaccinationService;
use Symfony\Component\HttpFoundation\JsonResponse;

class VaccineRegistrationController extends Controller
{
    protected VaccinationService $vaccinationService;

    public function __construct(VaccinationService $vaccinationService)
    {
        $this->vaccinationService = $vaccinationService;
    }

    public function register(VaccinationRegistrationRequest $request): JsonResponse
    {
        $response = $this->vaccinationService->registerUser(
        $request->name,
        $request->email,
        $request->phone,
        $request->nid,
        $request->vaccine_center_id
        );

        return response()->json($response, $response['success'] ? 201 : 400);
    }

    public function checkStatus($nid): JsonResponse
    {
        $status = $this->vaccinationService->checkRegistrationStatus($nid);
        return response()->json(['status' => $status], 200);
    }
}
