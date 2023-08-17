<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\API\AuthController;

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

Route::prefix('auth')->middleware('api')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login')->name('login');
    Route::get('/user', 'user');
    Route::post('/logout', 'logout');
    Route::post('subscribe', [SubscribersController::class, 'store'])->name('verification.notice');
    Route::get('/email/verify/{hash}', [SubscribersController::class, 'verify'])->name('subscriber.verify');

});
Route::get('/product/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
Route::get('/products/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('products.search');
