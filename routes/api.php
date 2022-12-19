<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Item\ItemController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\SubCategory\SubCategoryController;
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
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::post('create-order', [OrderController::class, 'create'])->name('api.order.create');
});

Route::get('categories', [CategoryController::class, 'index'])->name('api.category.index');
Route::get('categories/{uuid}', [CategoryController::class, 'show'])->name('api.category.show');
Route::get('categories/{categoryUuid}/sub-categories', [SubCategoryController::class, 'index'])->name('api.sub.category.index');
Route::get('categories/{categoryUuid}/sub-categories/{uuid}', [SubCategoryController::class, 'show'])->name('api.sub.category.show');
Route::get('sub-categories/{subCategoryUuid}/items', [ItemController::class, 'index'])->name('api.item.index');
Route::get('sub-categories/{subCategoryUuid}/items/{uuid}', [ItemController::class, 'show'])->name('api.item.show');
