<?php

namespace App\Http\Controllers;

use App\Models\VaccineCenter;
use Symfony\Component\HttpFoundation\JsonResponse;

class VaccinationCenterController extends Controller
{
    public function index(): JsonResponse
    {
        $centers = VaccineCenter::select('id', 'name')->get();

        return response()->json(['data' => $centers], 200);
    }
}
