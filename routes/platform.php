<?php

declare(strict_types=1);

use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\Category\CategoryScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;
use App\Orchid\Screens\Product\ProductScreen;
use App\Orchid\Screens\Category\UpdateCategory;
use App\Orchid\Screens\Category\AddCategory;
use App\Orchid\Screens\Product\AddProduct;
use App\Orchid\Screens\Product\UpdateProduct;
use App\Orchid\Screens\Subscribers\SubscribersScreen;
use App\Orchid\Screens\Subscribers\AddSubscribersScreen;
use App\Orchid\Screens\NewsLetter\NewsLetterScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

///admin
Route::screen('category', CategoryScreen::class)
    ->name('platform.category');

Route::screen('category-edit/{category}', UpdateCategory::class)
    ->name('platform.category.edit');

Route::screen('category-delete/{category}', CategoryScreen::class)
    ->name('platform.category.delete');

Route::screen('category-add', AddCategory::class)
    ->name('platform.category.add');

Route::screen('product-add', AddProduct::class)
    ->name('platform.product.add');

Route::screen('product-edit/{product}', UpdateProduct::class)
    ->name('platform.product.edit');

Route::screen('product', ProductScreen::class)
    ->name('platform.products');

Route::screen('subscribers', SubscribersScreen::class)
    ->name('platform.subscribers');
Route::screen('subscriber-add', AddSubscribersScreen::class)
    ->name('platform.subscriber.add');
Route::screen('newsletter', NewsLetterScreen::class)
    ->name('platform.newsletter');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });
