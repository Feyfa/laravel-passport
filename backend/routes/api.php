<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\OpenApiController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/openapi/create/user', [OpenApiController::class, 'createUser']);
    Route::post('/openapi/sso/login', [OpenApiController::class, 'loginWithoutPassword']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/openapi/token/validation', [OpenApiController::class, 'ssotokenvalidation']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/tokenvalidation', [AuthController::class, 'tokenvalidation']);
        Route::get('/users/{id}', [AuthController::class, 'show']);
    });

});

