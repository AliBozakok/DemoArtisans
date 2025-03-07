<?php

use App\Http\Controllers\Admin\employeeController;
use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\Employee\categoryController;
use App\Http\Controllers\Employee\productController;
use App\Http\Controllers\Employee\userWalletController;
use App\Http\Controllers\User\cartController;
use App\Http\Controllers\User\orderController;
use App\Http\Controllers\User\userController;
use App\Http\Controllers\User\userProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([

    'middleware' => 'auth:admin',
    'prefix' => 'auth'

], function ($router) {

    Route::apiResource('employee',employeeController::class);

});
Route::group([

    'middleware' => 'auth:employee',
    'prefix' => 'auth'

], function ($router) {

    Route::apiResource('category',categoryController::class);
    Route::get('selectByName',[categoryController::class,'selectByName']);
    Route::apiResource('product',productController::class);
    Route::get('category/{categoryId}/product', [ProductController::class,'showByCategory']);
    Route::get('search', [ProductController::class,'search']);
    Route::apiResource('wallet',userWalletController::class)->only(['index','store']);
});

    Route::apiResource('userProduct',userProductController::class)->only(['index','show']);
    Route::get('recentUserProduct', [userProductController::class,'recent']);
    Route::post('userRegister', [userController::class,'register']);
    Route::post('forgetPassword', [userController::class,'forgetPassword']);
    Route::post('resetPassword', [userController::class,'resetPassword']);
    Route::get('productSearch', [userProductController::class,'search']);

Route::group([

    'middleware' => 'auth:user',
    'prefix' => 'auth'

], function ($router) {

    Route::apiResource('cart',cartController::class)->except('show');
    Route::put('removeItem/{id}', [cartController::class,'remove']);
    Route::apiResource('order', orderController::class)->only(['index','store']);

});


Route::group([

    'middleware' => 'auth:sanctum',
    'prefix' => 'auth'

], function ($router) {
    Route::get('logout', [authController::class,'logout']);
    Route::get('profile', [authController::class,'profile']);
});
