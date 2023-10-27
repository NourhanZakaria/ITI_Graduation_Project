<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\LawyerController;
use App\Http\Controllers\api\SpecializationController;

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ReviewController;
use App\Http\Controllers\api\CityController;

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

Route::apiResource('lawyers',LawyerController::class);

Route::post('lawyers/search',[LawyerController::class,'search']);

Route::apiResource('specializations',SpecializationController::class);

Route::apiResource('reviews',ReviewController::class);

Route::apiResource('cities',CityController::class);
