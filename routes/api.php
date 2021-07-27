<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\Chat\ChatController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HealthWorkerController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientEncounterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/sanctum/token', TokenController::class);
Route::middleware(['auth:sanctum'])->group(function () {
    // Endpoints for Healworkers Access
    Route::group(['middleware' => ['healthworker']], function () {
        Route::apiResource('healthworker', HealthWorkerController::class);
        Route::get('analytics', DashboardController::class);
    });

    // Endpoints for patients
    Route::apiResource('patient', PatientController::class);
    Route::apiResource('patient/encounter', PatientEncounterController::class);
    Route::post('allPatients', [PatientController::class, 'allPatients']);

    // GENERAL ENDPOINTS
    Route::get('/users/me', MeController::class);
    // Chats Endpoints
    Route::group(['prefix' => 'chats'], function () {
        Route::post('', [ChatController::class, 'sendMessage']);
        Route::get('', [ChatController::class, 'getUserChats']);
        Route::get('{id}/messages', [ChatController::class, 'getChatMessages']);
        Route::put('{id}/markAsRead', [ChatController::class, 'markAsRead']);
        Route::delete('messages/{id}', [ChatController::class, 'destroyMessage']);
    });
});
