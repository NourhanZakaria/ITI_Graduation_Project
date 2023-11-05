<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\api\LawyerController;
use App\Http\Controllers\api\SpecializationController;

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ShowReviewController;
use App\Http\Controllers\api\LawyerTimeController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\GroupController;
use App\Http\Controllers\api\FollowersController;
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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        //'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();
    //if (! $user || ! $request->password == $user->password) {
    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // dd($user);
    return [
        $user->createToken($request->email)->plainTextToken,
        $user
    ];
});

Route::post('/logout', function (Request $request) {

    $user = Auth::guard('sanctum')->user();
    $token =  $user->currentAccessToken();
    $token->delete();

    return response('Logged_out', 200);
});
Route::apiResource('lawyers', LawyerController::class);

Route::post('lawyers/search', [LawyerController::class, 'search']);

Route::apiResource('specializations', SpecializationController::class);

Route::apiResource('lawyerTimes', LawyerTimeController::class);
Route::apiResource('reviews', ShowReviewController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('groups', GroupController::class);
Route::apiResource('followers', FollowersController::class);

Route::apiResource('cities', CityController::class);


Route::post('joinGroups', [GroupController::class, 'join']);
Route::post('messages', [\App\Http\Controllers\ChatController::class, 'message']);
