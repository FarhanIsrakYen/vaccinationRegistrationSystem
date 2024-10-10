<?php

use App\Http\Controllers\VaccinationCenterController;
use App\Http\Controllers\VaccineRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [VaccineRegistrationController::class, 'register']);
Route::get('/search/{nid}', [VaccineRegistrationController::class, 'checkStatus']);
Route::get('/centers', [VaccinationCenterController::class, 'index']);
