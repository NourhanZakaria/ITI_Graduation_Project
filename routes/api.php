<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Lawyer;
use App\Http\Controllers\api\LawyerController;
use App\Http\Controllers\api\SpecializationController;

use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ShowReviewController;
use App\Http\Controllers\api\LawyerTimeController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\GroupController;
use App\Http\Controllers\api\FollowersController;
use App\Http\Controllers\api\CityController;
use App\Http\Controllers\api\AppointmentController;
use App\Http\Controllers\api\NotificationsController;
use App\Http\Controllers\api\PaypalController;



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
    //dd($user->id);

    $lawyers = Lawyer::join('users', 'users.id', 'lawyers.user_id')
        ->join('cities', 'cities.id', 'users.city_id')
        ->where('lawyers.user_id', $user->id)
        ->get();

   // if (! $user || ! $request->password == $user->password) {
    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    // dd($user);
    if ($user->role == 'user') {
        return [
            $user->createToken($request->email)->plainTextToken,
            $user
        ];
    } else {
        return [
            $user->createToken($request->email)->plainTextToken,
            $lawyers
        ];
    }
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
Route::apiResource('cities', CityController::class);
Route::apiResource('appointments', AppointmentController::class);
Route::post('lawyer_appointments', [AppointmentController::class, 'lawyer_appointments']);
Route::get('notifications', [NotificationsController::class, 'notifications']);

Route::post('paypal/payment', [PaypalController::class, 'payment'])->name('paypal');
Route::get('paypal/success', [PaypalController::class, 'success'])->name('paypal_success');
Route::get('paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal_cancel');


Route::apiResource('lawyerTimes', LawyerTimeController::class);
Route::apiResource('reviews', ShowReviewController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('groups', GroupController::class);
Route::apiResource('followers', FollowersController::class);



Route::post('joinGroups', [GroupController::class, 'join']);
