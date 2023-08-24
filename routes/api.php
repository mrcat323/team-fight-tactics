<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribersController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
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
});

Route::post('subscribe', [SubscribersController::class, 'store'])->name('verification.notice');
Route::get('/email/verify/{hash}', [SubscribersController::class, 'verify'])->name('subscriber.verify');
Route::get('/email/unverify/{hash}', [SubscribersController::class, 'unVerify'])->name('subscriber.unverify');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/search', [SearchController::class, 'search'])->name('products.search');

Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');

Route::get('tags', [TagController::class, 'index'])->name('tag.index');
Route::get('/tag/{id}', [TagController::class, 'show'])->name('tag.show');
