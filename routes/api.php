<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ShowReviewController;
use App\Http\Controllers\api\LawyerTimeController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\GroupController;
use App\Http\Controllers\api\FollowersController;
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



Route::apiResource('lawyerTimes',LawyerTimeController::class);
Route::apiResource('reviews',ShowReviewController::class);
Route::apiResource('posts',PostController::class);
Route::apiResource('users',UserController::class);
Route::apiResource('groups',GroupController::class);
Route::apiResource('followers',FollowersController::class);