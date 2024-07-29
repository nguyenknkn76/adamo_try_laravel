<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\TestController;
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

// Route::get('/user/{id}',function($id){
//     return User::with('profile')->findOrFail($id);
// });

//todo routes for Users + Profiles
Route::apiResource('users',UserController::class);
Route::apiResource('profiles',ProfileController::class);
Route::apiResource('notes', NoteController::class);
// Route::middleware('auth:sanctum')->group(function(){
// });

//todo routes for Posts + Comments
Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentController::class);
// get post with comments containing 'A'
Route::get('posts/{id}/comments-with-a',[PostController::class, 'commentsWithA']);

//! routes for students and courses
Route::apiResource('students', StudentController::class);
Route::apiResource('courses', CourseController::class);

Route::post('import-cities', [CityController::class, 'importCities']);
Route::post('import-cities2', [CityController::class, 'importCities2']);

//todo authentiacaion
// Route::post('/login', [AuthController::class, 'login'])->middleware('log.requests');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

//? TEST CACHE
Route::prefix('cache')->group(function () {
    Route::get('/save', [TestController::class, 'saveCache']);
    Route::get('/get', [TestController::class, 'getCache']);
    Route::get('/delete', [TestController::class, 'deleteCache']);
});

//! FUNC: reset PW & send OTP to email
Route::post('/send-otp', [PasswordResetController::class, 'sendOtp']);
Route::post('/verify-otp', [PasswordResetController::class, 'verifyOtp']);

//! TRY: call third party api 
Route::get('/try-call-api/{term}', [TestController::class, 'tryCallThirdPartyApi']);

//! TRY: send sms
Route::post('/try-send-sms', [TestController::class, 'trySendOTPWithSMS']);