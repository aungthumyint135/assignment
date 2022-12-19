<?php

use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\Admin\AdminController;
use App\Http\Controllers\Web\Category\CategoryController;
use App\Http\Controllers\Web\Item\ItemController;
use App\Http\Controllers\Web\Permission\PermissionController;
use App\Http\Controllers\Web\Role\RoleController;
use App\Http\Controllers\Web\SubCategory\SubCategoryController;
use App\Http\Controllers\Web\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::post('login', [AuthenticationController::class, 'login'])->name('login');
Route::get('login', [AuthenticationController::class, 'showLoginForm'])->name('admin.login.form');

Route::middleware('auth:admins')->group(function () {
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');

    Route::get('permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
    Route::resource('roles', RoleController::class)->names('admin.role')->except('show');
    Route::resource('users', UserController::class)->names('admin.user')->only(['create', 'store', 'index']);
    Route::get('user/{uuid}/activate', [UserController::class, 'activate'])->name('admin.user.activate');
    Route::get('user/{uuid}/deactivate', [UserController::class, 'deactivate'])->name('admin.user.deactivate');
    Route::resource('admins', AdminController::class)->names('admin.admin')->except('show');
    Route::resource('categories', CategoryController::class)->names('admin.category')->except('show');
    Route::resource('sub-categories', SubCategoryController::class)->names('admin.sub.category')->except('show');
    Route::resource('items', ItemController::class)->names('admin.item')->except('show');

    Route::prefix('ajax')->group(function () {
        Route::post('roles', [RoleController::class, 'roles'])->name('ajax.roles');
        Route::post('permissions', [PermissionController::class, 'permissions'])->name('ajax.permissions');
        Route::post('admins', [AdminController::class, 'admins'])->name('ajax.admins');
        Route::post('users', [UserController::class, 'users'])->name('ajax.users');
        Route::post('categories', [CategoryController::class, 'categories'])->name('ajax.categories');
        Route::post('sub-categories', [SubCategoryController::class, 'subCategories'])->name('ajax.sub.categories');
        Route::post('items', [ItemController::class, 'items'])->name('ajax.items');
    });
});



