<?php

use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function (){
    $result = funcHelloWorld('Nguyen');
    return view('hello',['result' => $result]);
});
Route::get('/sus', function(){
    return 'very sus' ;
});
Route::get('/test-email', [PasswordResetController::class, 'testEmail']);
