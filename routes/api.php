<?php

use App\Http\Controllers\Api\Chat\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\TokenController;

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
    Route::group(['middleware' => ['healthworker']], function(){

    });

    // GENERAL ENDPOINTS
    Route::get('/users/me', MeController::class);
    // Chats Endpoints
    Route::group(['prefix' => 'chats'],function(){
        Route::post('', [ChatController::class, 'sendMessage']);
        Route::get('', [ChatController::class, 'getUserChats']);
        Route::get('{id}/messages', [ChatController::class, 'getChatMessages']);
        Route::put('{id}/markAsRead', [ChatController::class, 'markAsRead']);
        Route::delete('messages/{id}', [ChatController::class, 'destroyMessage']);
    });
});
