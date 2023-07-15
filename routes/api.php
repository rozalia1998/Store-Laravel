<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Middleware\CheckMiddleware;
use App\Http\Middleware\AdminMiddleware;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('products', ProductController::class);
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::put('/users/update',[UserController::class, 'update']);
    Route::delete('/users/delete',[UserController::class, 'destroy']);
    Route::get('/products',[ProductController::class, 'index']);
    Route::get('/products/show/{id}',[ProductController::class, 'show']);
    Route::post('/products/search/{id}',[ProductController::class, 'search']);
    Route::post('/products/filterprice',[ProductController::class, 'FilterPrice']);
    Route::post('/order/addOrder',[OrderController::class, 'addOrder']);
    Route::post('/Review/add/{id}',[ReviewController::class, 'addReview']);
    Route::get('/Review/view/{id}',[ReviewController::class, 'showProductRev']);
    Route::get('/Review/viewOrdered/{id}',[ReviewController::class, 'ordered']);
    Route::get('/Review/orderAll',[ReviewController::class, 'orderAll']);
    Route::prefix('admin')->middleware('admin')->group(function (){
        Route::post('/role/create',[RoleController::class, 'addRole']);
        Route::post('/userroles/add/{uid}/{rid}',[UserRoleController::class, 'addUserRole']);
        Route::delete('/userroles/delete/{uid}/{rid}',[UserRoleController::class, 'deleteUserRole']);
        Route::post('/products/create',[ProductController::class, 'store']);
        Route::put('/products/update/{id}',[ProductController::class, 'update']);
        Route::delete('/products/delete/{id}',[ProductController::class, 'destroy']);
    });

});
