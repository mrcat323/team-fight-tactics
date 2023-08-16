<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->middleware('api')->controller(\App\Http\Controllers\API\AuthController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login')->name('login');
    Route::get('/user', 'user');
    Route::post('/logout', 'logout');
});
